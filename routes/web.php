<?php

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

Route::get('/', 'PostController@index');
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

Auth::routes();
Route::get('api/post','PostController@getData');
Route::get('/search_post', 'PostController@searchPost')->name('search_post');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/new_post', function () {
    return view('new_post');
})->name('new_post');
Route::post('/new_post', 'PostController@createPost')->name('new_post');
Route::get('/post/{id}', 'PostController@show')->name('post');
Route::post('/setanswer','PostController@setAnswer');
Route::post('/new_answer','PostController@newAnswer')->name('new_answer');
Route::post('/new_answer/{id}', 'PostController@newAnswer');
Route::get('/vote_post', 'PostController@votePost')->name('vote_post');
Route::get('/delete_row','ProfileController@deleteRow')->name('delete_row');
Route::get('/profile', 'ProfileController@profile')->name('profile');
Route::get('/account', 'ProfileController@account')->name('account');
Route::post('/modify', 'ProfileController@modifyAccount')->name('modify');
Route::get('/admin', 'ProfileController@admin')->name('admin');
Route::get('/deleteAccount', 'ProfileController@deleteAccount')->name('deleteAccount');
