<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $rentLogs = RentLogs::with(['user','book'])->where('user_id', Auth::user()->id)->get();

        return view ('profile',compact('rentLogs'));
    }

    public function index()
    {
        // $user = DB::table('users')->where('role_id', 2)->get();
        $user = User::where('role_id', 2)->where('status','active')->get();
        return view ('user', ['user'=>$user]);
    }

    public function registeredUser()
    {
        $registeredUser = DB::table('users')->where('status','inactive')->where('role_id',2)->get();
        return view ('registered-users', ['registeredUser'=>$registeredUser]);
    }
    public function show($username)
    {
        // // $category = DB::table('categories')->where('name', $name)->first();
        // $user = DB::table('users')->where('username', $username)->first();
        // $rentLogs = RentLogs::with(['user','book'])->where('user_id',$user_id)->get();
        // return view ('user-detail', ['user'=>$user, 'rentLogs'=>$rentLogs]);


        $user = User::where('username', $username)->first();
        $rentLogs = RentLogs::with(['user','book'])->where('user_id', $user->id)->get();
        return view('user-detail',compact('user', 'rentLogs'));
    }
    public function approve($username)
    {
        $user = DB::table('users')->where('username', $username)->update([
            'status'=>'active',
        ]);
        return redirect ('user-detail/'.$username)-> with ('status','User approved successfully!'); 
    }

    public function delete($username)
    {
        // $user = DB::table('users')->where('username', $username)->first();
        // return view('user-delete',['user'=>$user]);

        $user = User::where('username', $username)->first();
        return view('user-delete',['user'=>$user]);

    }

    public function destroy($username)
    {
        $user = DB::table('users')->where('username', $username)->update(['deleted_at' => Carbon::now()]);
        return redirect ('/users')-> with ('status','User deleted successfully!'); 
    }

}
