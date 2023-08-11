<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/slander/{id?}', 'App\Http\Controllers\SlanderController@slander');
Route::get('/slander_all', 'App\Http\Controllers\SlanderController@all');
Route::get('/slander_new', 'App\Http\Controllers\SlanderController@getNewSlander');
Route::get('/slander_connection/{id?}', 'App\Http\Controllers\SlanderController@getConnection');
Route::get('/slander_connection_all/{id?}', 'App\Http\Controllers\SlanderController@getConnection_all');
Route::post('/slander_create', 'App\Http\Controllers\SlanderController@create');

Route::get('/comment_top/{id?}/{order?}', 'App\Http\Controllers\CommentController@topComment');
Route::get('/comment_top_all/{id?}/{order?}', 'App\Http\Controllers\CommentController@topComment_all');
Route::get('/comment_under/{id?}', 'App\Http\Controllers\CommentController@underComment');
Route::get('/comment_all', 'App\Http\Controllers\CommentController@all');
Route::post('/comment_create', 'App\Http\Controllers\CommentController@create');

Route::get('/comment_evaluation_all', 'App\Http\Controllers\CommentEvaluationController@all');
Route::post('/comment_evaluation_create', 'App\Http\Controllers\CommentEvaluationController@create');
Route::post('/comment_evaluation_delete', 'App\Http\Controllers\CommentEvaluationController@destroy');

Route::get('/slander_evaluation_all', 'App\Http\Controllers\SlanderEvaluationController@all');
Route::post('/slander_evaluation_create', 'App\Http\Controllers\SlanderEvaluationController@create');
Route::post('/slander_evaluation_delete', 'App\Http\Controllers\SlanderEvaluationController@destroy');

Route::get('/report_all', 'App\Http\Controllers\ReportController@all');
Route::post('/report_create', 'App\Http\Controllers\ReportController@create');

Route::post('/lawyer_all', 'App\Http\Controllers\LawyerController@all');
Route::get('/lawyer_comment/{id?}', 'App\Http\Controllers\LawyerCommentController@getComment');
Route::post('/lawyer', 'App\Http\Controllers\LawyerController@getLawyer');
Route::post('/lawyer_create', 'App\Http\Controllers\LawyerController@create');
Route::post('/lawyer_comment_create', 'App\Http\Controllers\LawyerCommentController@create');
Route::post('/auth', 'App\Http\Controllers\LawyerController@auth');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
