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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->post('/file/upload', 's3FilesController@upload');
Route::middleware('cors')->delete('/file/{file_id}', 's3FilesController@delete');
Route::middleware('cors')->get('/file/{file_id}', 's3FilesController@retrieve');

