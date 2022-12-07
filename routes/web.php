<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RentLogController;
use App\Http\Controllers\BookRentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[PublicController::class,'index']);

Route::middleware('only_guest')->group(function () {
    Route::get('/login',[AuthController::class, 'login'])->name('login');
    Route::post('/login',[AuthController::class, 'authenticating']);
    Route::get('/register',[AuthController::class, 'register']);
    Route::post('/register',[AuthController::class, 'registerProcess']);

});

Route::middleware('auth')->group(function () {
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::get('/profile',[UserController::class, 'profile'])->middleware('only_client');
    
   
    Route::middleware('only_admin')->group(function () {
        Route::get('/dashboard',[DashboardController::class, 'index']);
        
        Route::get('/books',[BookController::class, 'index']);
        Route::get('/book-add',[BookController::class, 'add']);
        Route::post('/book-add',[BookController::class, 'store']);
        Route::get('/book-edit/{book_code}',[BookController::class, 'edit']);
        Route::post('/book-edit/{book_code}',[BookController::class, 'update']);
        Route::get('/book-delete/{book_code}',[BookController::class, 'delete']);
        Route::get('/book-destroy/{book_code}',[BookController::class, 'destroy']);
        Route::get('/book-deleted',[BookController::class, 'deletedBook']);
        Route::get('/book-restore/{book_code}',[BookController::class, 'restore']);
    
        Route::get('/categories',[CategoryController::class, 'index']);
        Route::get('/category-add',[CategoryController::class, 'add']);
        Route::post('/category-add',[CategoryController::class, 'store']);
        Route::get('/category-edit/{name}',[CategoryController::class, 'edit']);
        Route::put('/category-edit/{name}',[CategoryController::class, 'update']);
        Route::get('/category-delete/{name}',[CategoryController::class, 'delete']);
        Route::get('/category-destroy/{name}',[CategoryController::class, 'destroy']);
        Route::get('/category-deleted',[CategoryController::class, 'deletedCategory']);
        Route::get('/category-restore/{name}',[CategoryController::class, 'restore']);
        // Route::get('/ category-hd/{name}',[CategoryController::class, 'deletedFix']);

       
    
    
        Route::get('/users',[UserController::class, 'index']);
        Route::get('/registered-users',[UserController::class, 'registeredUser']);
        Route::get('/user-detail/{username}',[UserController::class, 'show']);
        Route::get('/user-approve/{username}',[UserController::class, 'approve']);
        // Route::get('/user-delete/{username}',[UserController::class, 'delete']);
        // Route::get('/user-destroy/{username}',[UserController::class, 'destroy']);
        // Route::get('/user-deleted',[userController::class, 'deletedUser']);
        // Route::get('/user-restore/{username}',[userController::class,'restore']);

        Route::get('/book-rent',[BookRentController::class, 'index']);
        Route::post('/book-rent',[BookRentController::class, 'store']);

        Route::get('book-return',[BookRentController::class, 'returnBook']);
        Route::post('book-return',[BookRentController::class, 'saveReturnBook']);

        Route::get('/rent-log',[RentLogController::class, 'index']);
    });

});
