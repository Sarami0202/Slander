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
Route::get('/slander_admin_search/{id?}', 'App\Http\Controllers\SlanderController@adminSearch');
Route::post('/slander_search', 'App\Http\Controllers\SlanderController@search');
Route::get('/slander_all', 'App\Http\Controllers\SlanderController@all');
Route::get('/slander_new/{num?}', 'App\Http\Controllers\SlanderController@getNewSlander');
Route::get('/slander_new_all/{num?}/{page?}', 'App\Http\Controllers\SlanderController@getNewAllSlander');
Route::get('/slander_month/{num?}', 'App\Http\Controllers\SlanderController@getMonthSlander');
Route::get('/slander_month_all/{num?}/{page?}', 'App\Http\Controllers\SlanderController@getMonthAllSlander');
Route::get('/slander_preview/{num?}', 'App\Http\Controllers\SlanderController@getPreviewSlander');
Route::get('/slander_preview_all/{num?}/{page?}', 'App\Http\Controllers\SlanderController@getPreviewAllSlander');
Route::get('/slander_preview_month/{num?}/{page?}', 'App\Http\Controllers\SlanderController@getPreviewMonthSlander');
Route::get('/slander_connection/{id?}/{num?}', 'App\Http\Controllers\SlanderController@getConnection');
Route::get('/slander_connection_top/{id?}', 'App\Http\Controllers\SlanderController@getConnectionTop');
Route::get('/slander_connection_all/{id?}/{num?}', 'App\Http\Controllers\SlanderController@getConnection_all');
Route::post('/slander_other/{num?}', 'App\Http\Controllers\SlanderController@getOther');
Route::post('/slander_create', 'App\Http\Controllers\SlanderController@create');
Route::post('/slander_delete', 'App\Http\Controllers\SlanderController@destroy');
Route::post('/slander_view', 'App\Http\Controllers\SlanderController@viewUpdate');

Route::get('/comment_top/{id?}/{order?}', 'App\Http\Controllers\CommentController@topComment');
Route::get('/comment_top_all/{id?}/{order?}', 'App\Http\Controllers\CommentController@topComment_all');
Route::get('/comment_under/{id?}', 'App\Http\Controllers\CommentController@underComment');
Route::get('/comment_all', 'App\Http\Controllers\CommentController@all');
Route::post('/comment_create', 'App\Http\Controllers\CommentController@create');
Route::post('/comment_delete', 'App\Http\Controllers\CommentController@destroy');

Route::get('/comment_evaluation_all', 'App\Http\Controllers\CommentEvaluationController@all');
Route::post('/comment_evaluation_create', 'App\Http\Controllers\CommentEvaluationController@create');
Route::post('/comment_evaluation_delete', 'App\Http\Controllers\CommentEvaluationController@destroy');

Route::get('/slander_evaluation_all', 'App\Http\Controllers\SlanderEvaluationController@all');
Route::post('/slander_evaluation_create', 'App\Http\Controllers\SlanderEvaluationController@create');
Route::post('/slander_evaluation_delete', 'App\Http\Controllers\SlanderEvaluationController@destroy');

Route::get('/report_all', 'App\Http\Controllers\ReportController@all');
Route::get('/report/{id?}', 'App\Http\Controllers\ReportController@getReport');
Route::get('/report_count/{id?}', 'App\Http\Controllers\ReportController@getCount');
Route::post('/report_create', 'App\Http\Controllers\ReportController@create');

Route::post('/lawyer_all', 'App\Http\Controllers\LawyerController@all');
Route::get('/lawyer_comment/{id?}', 'App\Http\Controllers\LawyerCommentController@getComment');
Route::get('/lawyer_comment_all/{id?}', 'App\Http\Controllers\LawyerCommentController@getLawyerComment');
Route::post('/lawyer_update', 'App\Http\Controllers\LawyerController@update');
Route::post('/lawyer_license', 'App\Http\Controllers\LawyerController@licenseUpdate');
Route::post('/lawyer_delete', 'App\Http\Controllers\LawyerController@destroy');
Route::post('/lawyer', 'App\Http\Controllers\LawyerController@getLawyer');
Route::post('/lawyer_request', 'App\Http\Controllers\LawyerController@getRequestLawyer');
Route::post('/lawyer_create', 'App\Http\Controllers\LawyerController@create');
Route::post('/lawyer_comment_create', 'App\Http\Controllers\LawyerCommentController@create');
Route::post('/lawyer_comment_delete', 'App\Http\Controllers\LawyerCommentController@destroy');
Route::post('/auth', 'App\Http\Controllers\LawyerController@auth');


Route::post('/inquiry_send', 'App\Http\Controllers\MailController@inquirySend');
Route::post('/PRinquiry_send', 'App\Http\Controllers\MailController@PRinquirySend');
Route::post('/LawyerInquiry_send', 'App\Http\Controllers\MailController@LawyerInquirySend');
Route::post('/reception_send', 'App\Http\Controllers\MailController@ReceptionSend');
Route::get('/preview_all', 'App\Http\Controllers\SlanderController@preview_all');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});