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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat', 'ChatController@index')->name('chat');

Route::get('/message/{id}', 'MessageController@index')->name('message');
Route::post('/message', 'MessageController@store')->name('message.store');

Route::get('/test', function () {
    return view('test');
});


Route::get('/conversations', 'ConversationController@getConversationsList');
Route::get('/conversations/{user_id}', 'ConversationController@startConversation');
Route::get('/conversations/{id}/users', 'ConversationController@getParticipants');
Route::get('/conversations/{id}/messages', 'ConversationController@getMessages');

