<?php


/* protected urls */
Route::group(array('before' => 'auth', 'prefix' => 'crud'), function()
{

	//----------Permission
	Route::get('/index', array('as' => 'crud-index', 'uses' => 'CrudController@index'));

	Route::any('/create', array('as' => 'crud-create', 'uses' => 'CrudController@create'));
	Route::any('/read/{id?}', array('as' => 'crud-read', 'uses' => 'CrudController@read'));
	Route::any('/update/{id?}', array('as' => 'crud-update', 'uses' => 'CrudController@update'));
	Route::any('/delete/{id?}', array('as' => 'crud-delete', 'uses' => 'CrudController@delete'));

	Route::any('/bulk/action', array('as' => 'crud-bulk-action', 'uses' => 'CrudController@bulkAction'));

});