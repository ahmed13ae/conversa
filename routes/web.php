<?php

use App\Http\Controllers\ExController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/admin", function () {
    return 'in adnmin page';
})->middleware('can:admin');

//user related routes
Route::get('/',[UserController::class,'showCorrectHome'])->name('login');
Route::post('/register',[UserController::class,'register'])->middleware('guest');
Route::post('/login',[UserController::class,'login'])->middleware('guest');
Route::post('/logout',[UserController::class,'logout'])->middleware('loggedIn');

//post realated routes
Route::get('/create-post',[PostController::class,'showCreateForm'])->middleware('loggedIn');
Route::post('/create-post',[PostController::class,'createPost'])->middleware('loggedIn');
Route::get('/post/{post}',[PostController::class,'showSinglePost']);
Route::delete('/post/{post}',[PostController::class,'delete'])->middleware('can:delete,post'); 
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post'); 
Route::put('/post/{post}',[PostController::class,'update'])->middleware('can:update,post'); 


//profile related routes
Route::get('/profile/{user:username}',[UserController::class,'profile'])->middleware('loggedIn');
Route::get('/manage-avatar',[UserController::class,'showAvatarForm']);
Route::post('/manage-avatar',[UserController::class,'changeAvatar']);

