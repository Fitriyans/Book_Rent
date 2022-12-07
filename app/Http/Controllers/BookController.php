<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        // $books = DB::select('select * from books');
        $books = Book::all();
        return view ('book',['books'=>$books]);
    }

    public function add()
    {
        $categories = DB::select('select * from categories');
        // $categories = Category::all();
        return view ('book-add', ['categories'=>$categories]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title' => 'required|max:255',
        ]);
        $newName = '';
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover',$newName);
        }
        $request['cover']=$newName;
        $book = Book::create($request->all());
        // $book = DB::insert('INSERT INTO books(book_code, title, cover) VALUES (:book_code, :title, :cover)',
        // [
        //     'book_code' => $request->book_code,
        //     'title' => $request->title,
        //     'cover' => $request->cover,
        // ]);
        $book->categories()->sync($request->categories);
        return redirect ('books')-> with ('status','Category added successfully!'); 
        // dd($request->all());
    }
    
    public function edit($book_code)
    { 
        $book = Book::where('book_code',$book_code)->first();
        $categories = Category::all();

        return view ('book-edit',['categories'=>$categories, 'book'=>$book]);
    }

    public function update(Request $request, $book_code)
    {
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
            $request->file('image')->storeAs('cover',$newName);
            $request['cover']=$newName;
        }
        $book = Book::where('book_code',$book_code)->first();
        $book->update($request->all());

        if ($request->categories){
            $book->categories()->sync($request->categories);
        }
        return redirect ('books')-> with ('status','Book Updated successfully!'); 
    }

    public function delete($book_code)
    {
        $book = DB::table('books')->where('book_code', $book_code)->first();
        return view('book-delete',['book'=>$book]);
    }

    public function destroy($book_code)
    {
        $category = DB::table('books')->where('book_code', $book_code)->update(['deleted_at' => Carbon::now()]);
        return redirect ('books')-> with ('status','Book deleted successfully!'); 
    }

    public function deletedBook()
    {
        $deletedBooks = DB::table('books')->whereNotNull('deleted_at')->get();
        return view ('book-deleted-list',['deletedBooks'=>$deletedBooks]); 
    }

    // public function deletefix($book_code)
    // {
    //     $book = DB::update('UPDATE books SET deleted_at = NULL WHERE book_code = :book_code', ['book_code' => $book_code]);
    //     return redirect ('books')-> with ('status','Book restored successfully!'); 
    // }


}
