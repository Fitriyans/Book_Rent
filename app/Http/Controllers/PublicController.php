<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    // public function index()
    // {
        // $categories = DB::select('select * from categories');
        // $books = DB::select('select * from books');
    //     return view ('book-list',['books'=>$books, 'categories'=>$categories]);


    // }


    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->category || $request->title) {
            $books = Book::where('title', 'like', '%'. $request->title .'%')->orWhereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            })->get();
        } else {
            $books = Book::all();
        }
        // $categories = Category::all();
        // $categories = DB::select('select * from categories');
        // if ($request->category || $request->title) { 
        //     $books = DB::table('books')->where('title', 'like', '%'. $request->title .'%')->orWhereHas('categories', function ($q) use ($request) {
        //         $q->where('categories.id', $request->category);
        //     })->get();
        // } else {
        //     // $books = Book::all();
        //     $books = DB::select('select * from books');

        // }

        return view('book-list', ['books'=>$books, 'categories'=>$categories]);
    }
}
