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

///////////////////////////////////////////////////////////////////////////////  Calendarページ
// ホーム画面を表示する
Route::get('/', 'App\Http\Controllers\HomeController@showHome');

// カレンダーのページを変更する
Route::get('/get_request/{change_colendar?}', 'App\Http\Controllers\HomeController@showHome');

// ajax処理 現在時刻をサーバーから取得しjson形式でjsに渡す
Route::get('/ajax_currenttime', 'App\Http\Controllers\AjaxController@currenttime_data');

// TodoList 画面を表示する , カレンダーの日にちをクリック
Route::get('/plans_todolist/{todolist_select?}', 'App\Http\Controllers\TodoListController@showTodoList');
///////////////////////////////////////////////////////////////////////////////  Calendarページ



///////////////////////////////////////////////////////////////////////////////  Todolistページ
// ajax処理 Todolist[追加] 画面上から新規listされたデータをPOSTで渡す
Route::post('/todolist_form_data', 'App\Http\Controllers\TodoListController@_getNewPostData');

// ajax処理 Todolist[削除]
Route::post('/todolist_form_delete', 'App\Http\Controllers\TodoListController@_deleteData');

// ajax処理 Todolist[更新]
Route::post('/todolist_form_update', 'App\Http\Controllers\TodoListController@_update');
///////////////////////////////////////////////////////////////////////////////  Todolistページ



///////////////////////////////////////////////////////////////////////////////  Projectページ
// Project 一覧 + 新規生成ボタン
Route::get('/project_list', 'App\Http\Controllers\ProjectListController@showProjectList');

// Project 新規生成ページを表示する
Route::get('/project_create', 'App\Http\Controllers\ProjectCreateController@showProjectcreate');

// ajax処理 新規プロジェクト名を受け取る
Route::post('/project_create_name', 'App\Http\Controllers\ProjectCreateController@_getProjectCreateName');

// ajax処理 新規予定を作成し listに追加
Route::post('/project_create_plan', 'App\Http\Controllers\ProjectCreateController@_getProjectCreatePlan');

// ajax処理 新規プロジェクト 全てのlistを保存する
Route::post('/project_form_data', 'App\Http\Controllers\ProjectCreateController@_getProjectlistData');

// project 詳細画面 を表示する
Route::get('/project_management/{project_select?}', 'App\Http\Controllers\ProjectManagementController@_getselect_project_name');

// ajax処理 既存のprojectTodolistを 更新する
Route::post('/project_todolist_update', 'App\Http\Controllers\ProjectManagementController@_update_project');

// ajax処理 既存のprojectTodolistを 完全削除する
Route::post('/project_todolist_perfect_delete', 'App\Http\Controllers\ProjectManagementController@_perfect_delete_project');

// ajax処理 既存のprojectTodolistを 論理削除する
Route::post('/project_todolist_delete', 'App\Http\Controllers\ProjectManagementController@_delete_project');
///////////////////////////////////////////////////////////////////////////////  Projectページ