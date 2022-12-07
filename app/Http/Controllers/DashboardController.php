<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $bookCount = DB::table('books')->count();
        $categoryCount = DB::table('categories')->count();
        $userCount = DB::table('users')->count();
        $rentLogs = RentLogs::with(['user','book'])->get();

        return view ('dashboard', ['book_count'=>$bookCount,'category_count'=>$categoryCount,'user_count'=>$userCount, 'rentLogs' => $rentLogs]);
    }
}
