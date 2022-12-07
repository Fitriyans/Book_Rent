<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();

        // $users = DB::table('users')->where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = DB::select('select * from books');
        return view('book-rent',['users'=>$users, 'books'=>$books]);
    }

    public function store(Request $request)
    {
        //carbon now digunakan unutk mendapatkan data waktu sekarang
        $request['rent_date'] = Carbon::now()->toDateString(); //$request['rent_date'], yaitu mengisi request dengan name 'rent_date'
        $request['return_date'] = Carbon::now()->addDays(3)->toDateString(); //ditambah 3 hari

        //logika , tidak bisa meminjam buku yang sedang di pinjam
        $books = Book::find($request->book_id); //mencari buku dengan id sesuai request

        if ($books->status != 'in stock') {
            Session::flash('message', 'Book is being borrowed'); //unutk mengirimkan pesan ke book-rent
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        } else {
            //Fitur limit peminjaman
            $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count(); //ini mennghitung user dengan id tersebut sudah meminjam berapa buku.

            if ($count >= 3) {
                Session::flash('message', 'Cannot rent, user has reach limit of lending book'); //unutk mengirimkan pesan ke book-rent
                Session::flash('alert-class', 'alert-danger');
                return redirect('book-rent');
            } else {
                try {
                    //disini menggunakan DB transaction karena ada dua table yang sekaligus di ubah yaitu menambhakan data ke rent-logs dan mengupdate status buku di table books
                    DB::beginTransaction();

                    // RentLogs::create($request->all()); //menambahkan semua data hasil request ke dalam table rent-logs

                    DB::insert('INSERT INTO rent_logs(id, user_id, book_id, rent_date, return_date, actual_return_date, created_at, updated_at) VALUES (:id, :user_id, :book_id, :rent_date, :return_date, :actual_return_date, :created_at, :updated_at)',
                    [
                        'id' => $request->id,
                        'user_id'=> $request->user_id,
                        'book_id' => $request->book_id,
                        'rent_date' => $request->rent_date,
                        'return_date' => $request->return_date,
                        'actual_return_date' => $request->actual_return_date,
                        'created_at'=> $request->created_at,
                        'updated_at'=> $request->updated_at,
                    ]);

                    $book = Book::find($request->book_id);
                    $book->status = "not available"; //mengganti book status menjadi not available
                    $book->save();

                    DB::commit();

                    Session::flash('message', 'The book was successfully borrowed'); //unutk mengirimkan pesan ke book-rent
                    Session::flash('alert-class', 'alert-success');
                    return redirect('book-rent');
                } catch (\Throwable $th) {
                    DB::rollBack();
                }
            }
        }
    }

    
    public function returnBook()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = Book::all();
        return view('book-return', compact('users', 'books'));
    }

    public function saveReturnBook(Request $request)
    {
        $rent = RentLogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date', null);
        $rentData = $rent->first();
        $countData = $rent->count();

        if ($countData == 1) {
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();
            Session::flash('message', 'The book is returned successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect('book-return');
        } else {
            Session::flash('message', 'There is error in process');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-return');
        }
    }

    // public function store(Request $request)
    // {
    //     $request['rent_date']= Carbon::now()->toDateString();
    //     $request['return_date']= Carbon::now()->addDay(3)->toDateString();

    //     $book = Book::findOrFail($request->book_id)->only('status');

    //     if($book['status'] != 'in stock'){
    //         Session::flash('message','Cannot rent,the book is not available');
    //         Session::flash('alert-class','alert-danger');

    //         return redirect ('book_rent');
    //         // dd('buku sedang dipinjam');
    //     }
    //     else{
    // //         try{
    // //             DB::beginTransaction();
    // //             RentLogs::create($request->all);
    //             DB::insert('INSERT INTO rent_logs(id, user_id, book_id, rent_date, return_date, actual_return_date, created_at, updated_at) VALUES (:id, :user_id, :book_id, :rent_date, :return_date, :actual_return_date, :created_at, :updated_at)',
    //             [
    //                 'id' => $request->id,
    //                 'user_id'=> $request->user_id,
    //                 'book_id' => $request->book_id,
    //                 'rent_date' => $request->rent_date,
    //                 'return_date' => $request->return_date,
    //                 'actual_return_date' => $request->actual_return_date,
    //                 'created_at'=> $request->created_at,
    //                 'updated_at'=> $request->updated_at,
    //             ]);
    // //             $book = Book::findOrFail($request->book_id);
    // //             $book->status = 'not available';
    // //             $book->save();

                // $book = DB::table('books')->where('book_id', $book_id)->update([
                //     'status'=>'not available',
                // ]);

    // //             DB::commit();

    // //             Session::flash('message','Cannot rent,the book is not available');
    // //             Session::flash('alert-class','alert-danger');

    // //             return redirect ('book_rent');
    // //         }catch(\Throwable $th){
    // //             DB::rollback();
    //             dd($th);
    //         }

    //     }
    //         // dd('bisa pinjam buku');
    //     // $validated = $request->validate([
    //     //     'name' => 'required|unique:categories|max:100',
    //     // ]);
    //     // // $category = Category::create($request->all());
    //     // DB::insert('INSERT INTO categories(name) VALUES (:name)',
    //     // [
    //     //     'name' => $request->name,
    //     // ]);
    //     // return redirect ('categories')-> with ('status','Category added successfully!'); 
    // }

}
