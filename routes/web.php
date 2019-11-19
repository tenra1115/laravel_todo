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
Auth::routes();


Route::group(['middleware' => 'auth'], function() {
  // nameでコントローラーアクションに対しての名前をつけることができるので便利
  Route::get('/', 'HomeController@index')->name('home');
  
  Route::get('/folders/{i}/tasks', 'TaskController@index')->name('tasks.index');
  
  Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
  Route::post('/folders/create', 'FolderController@create');

  Route::get('/folders/{i}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
  Route::post('/folders/{i}/tasks/create', 'TaskController@create');
  
  // {}の中身はなんでも良いが、コントローラーでアクションを動かす際に呼び出す必要がある(ここの値を使う)
  Route::get('/folders/{i}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
  Route::post('/folders/{i}/tasks/{task_id}/edit', 'TaskController@edit');
});
