<?php


/* protected urls */
Route::group(array('before' => 'auth', 'prefix' => 'teacher'), function()
{

	//----------Permission
	Route::get('/index', array('as' => 'teacher-index', 'uses' => 'TeacherController@index'));
	Route::any('/create', array('as' => 'teacher-create', 'uses' => 'TeacherController@create'));
	Route::any('/read/{_id?}', array('as' => 'teacher-read', 'uses' => 'TeacherController@read'));
	Route::any('/update/{_id?}', array('as' => 'teacher-update', 'uses' => 'TeacherController@update'));
	Route::any('/delete/{_id?}', array('as' => 'teacher-delete', 'uses' => 'TeacherController@delete'));
	Route::any('/bulk/action', array('as' => 'teacher-bulk-action', 'uses' => 'TeacherController@bulkAction'));

});