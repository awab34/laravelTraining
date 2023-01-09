<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');

Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

Route::get('/posts', 'PostController@index')->name('posts');
Route::get('/posts/trashed', 'PostController@trashed')->name('posts.trashed');
Route::get('/post/create', 'PostController@create')->name('post.create');
Route::get('/post/store', 'PostController@store')->name('post.store');
Route::get('/post/edit/{id}', 'PostController@show')->name('post.edit');
Route::get('/post/update/{id}', 'PostController@edit')->name('post.update');
Route::get('/post/show/{slug}', 'PostController@update')->name('post.show');
Route::get('/post/delete/{id}', 'PostController@destroy')->name('post.delete');
Route::get('/post/soft/delete/{id}', 'PostController@softDelete')->name('post.soft.delete');
Route::get('/post/restore/{id}', 'PostController@restore')->name('post.restore');