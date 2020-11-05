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

Route::get('comprador', 'CompradorController@getAll');
Route::get('comprador/{id}', 'CompradorController@getByDoc');
Route::post('comprador', 'CompradorController@create');
Route::post('comprador/{id}/ticket', 'CompradorController@createTicket');

Route::get('ticket', 'TicketController@getAll');
Route::get('ticket/{id}', 'TicketController@getById');
Route::post('ticket', 'TicketController@create');