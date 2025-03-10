<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect('/books');
});

// Rotas para Books
Route::resource('books', BookController::class);

// Rotas para Authors
Route::resource('authors', AuthorController::class);

// Rotas para Categories
Route::resource('categories', CategoryController::class);

// Rotas para Publishers
Route::resource('publishers', PublisherController::class);


Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');









#use Illuminate\Support\Facades\Route;

#Route::get('/', function () {
#    return view('welcome');
#});

#Auth::routes();

#Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
