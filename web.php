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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

Auth::routes();
Route::get('api/post','PostController@getData');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/{id}', function($id){
    $post = App\Post::where('id', $id)->firstOrFail();

    return view('post', ['post' => $post]);
});