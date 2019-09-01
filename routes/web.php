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
Route::get('bot','BotController@index');
Route::post('bot','BotController@store');
Route::resource('{exam}/questions', 'QuestionController');
Route::resource('users', 'UserController');
Route::resource('exams', 'ExamController');
Route::resource('sends', 'SendToAllController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
