<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/task',[
	'uses'=>'TasksController@postTask',
	'middleware' => 'auth.jwt']);

Route::get('/tasks',[
	'uses'=>'TasksController@getTasks']);
Route::get('/tasks/{id}',[
	'uses'=>'TasksController@showTask']);
Route::put('/tasks/{id}',[
	'uses'=>'TasksController@updateTask',
	'middleware' => 'auth.jwt']);
Route::delete('/tasks/{id}',[
	'uses'=>'TasksController@deleteTask',
	'middleware' => 'auth.jwt']);
//Route for storing comment in the database
Route::post('comments/{id}',[
	'uses'=>'CommentsController@storeComment']);
//Route for 'task is finished'
Route::put('taskIsCompleted/{id}',[
	'uses' => 'TasksController@isCompleted']);
//Route for 'task is not finished'
Route::put('taskIsNotCompleted/{id}',[
	'uses' => 'TasksController@isNotCompleted']);
//Route for showing the comments of the specific task
Route::get('comments/{id}',[
	'uses' => 'TasksController@showComments']);
//Route for showing all the users in the database
Route::get('users',[
	'uses' => 'TasksController@getUsers']);
Route::post('/user',[
	'uses'=>'UserController@signup']);

Route::post('/user/signin',[
	'uses'=>'UserController@signin']);
//Route for showing the user of the specific task
Route::get('user/{id}',[
	'uses' => 'TasksController@showUser']);



Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//Route for signout
Route::post('signout', 'TasksController@signout');
//Route for sending email with mailtrap
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('emailMe');
