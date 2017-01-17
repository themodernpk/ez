<?php
//----------Doc
Route::get('/doc', array('as' => 'doc', 'uses' => 'CoreController@doc'));
//----------Setup
Route::get('/setup', array('as' => 'setup', 'uses' => 'SetupController@getIndex'));
Route::post('/setup', array('as' => 'setupPost', 'uses' => 'SetupController@setupPost'));
Route::get('/migrationsAndSeeds', array('as' => 'migrationsAndSeeds', 'uses' => 'SetupController@migrationsAndSeeds'));
Route::any('/migrationsAndSeedsRun', array('as' => 'migrationsAndSeedsRun', 'uses' => 'SetupController@migrationsAndSeedsRun'));
Route::get('/createAdmin', array('as' => 'createAdmin', 'uses' => 'SetupController@createAdmin'));
//----------Common pages
Route::get('/', array('as' => 'home', 'uses' => 'CoreController@getLogin'));
Route::get('/login', array('as' => 'login', 'uses' => 'CoreController@getLogin'));
Route::get('/forgot-password', array('as' => 'forgot-password', 'uses' => 'CoreController@getForgotPassword'));
Route::post('/forgot-password', array('as' => 'forgot-password-post', 'uses' => 'CoreController@postForgotPassword'));
Route::get('/reset-password/{otp?}', array('as' => 'reset-password', 'uses' => 'CoreController@getRestPassword'));
Route::post('/reset-password', array('as' => 'reset-password-post', 'uses' => 'CoreController@postRestPassword'));
Route::get('/error', array('as' => 'error', 'uses' => 'CoreController@getError'));
Route::any('/postlogin', array('as' => 'postlogin', 'uses' => 'CoreController@postLogin'));
Route::get('/register', array('as' => 'register', 'uses' => 'CoreController@getRegister'));
Route::any('/postregister', array('as' => 'postregister', 'uses' => 'CoreController@postRegister'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'CoreController@getLogout'));
Route::get('/upload', array('as' => 'upload', 'uses' => 'CoreController@getUpload'));
Route::any('/uploadFile', array('as' => 'uploadFile', 'uses' => 'CoreController@uploadFile'));
//----------Ajax
Route::group(['prefix' => 'ajax'], function () {
    Route::any('/syncpermissions', array('as' => 'syncpermissions', 'uses' => 'AjaxController@syncPermissions'));
    Route::any('/ajax_update_col', array('as' => 'ajax_update_col', 'uses' => 'AjaxController@ajax_update_col'));
    Route::any('/ajax_update_col_href', array('as' => 'ajax_update_col_href', 'uses' => 'AjaxController@ajax_update_col_href'));
    Route::any('/markRead', array('as' => 'markRead', 'uses' => 'AjaxController@markRead'));
    Route::any('/ajax_delete', array('as' => 'ajax_delete', 'uses' => 'AjaxController@ajax_delete'));
    Route::any('/ajax_edit', array('as' => 'ajax_edit', 'uses' => 'AjaxController@ajax_edit'));
});
//----------API
Route::group(['prefix' => 'api'], function () {
    Route::any('/test', array('as' => 'apitest', 'uses' => 'ApiController@apiTest'));
    Route::any('/help', array('as' => 'apihelp', 'uses' => 'ApiController@apiHelp'));
});
//----------Protected
Route::group(array('before' => 'auth'), function () {
    Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'CoreController@getDashboard'));
    Route::group(array('prefix' => 'admin'), function () {
        Route::post('bulkAction', array('as' => 'bulkAction', 'uses' => 'AdminController@bulkAction'));
        //----------Modules
        Route::get('modules', array('as' => 'modules', 'uses' => 'AdminController@getModules'));
        Route::any('moduleInstall', array('as' => 'moduleInstall', 'uses' => 'AdminController@moduleInstall'));
    });
});
Route::group(['prefix' => 'ajax'], function () {
    Route::any('/ajax_model_box', array('as' => 'ajax_model_box', 'uses' => 'AjaxController@ajax_model_box'));
});
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function () {
    Route::get('activities/list/', array('as' => 'activities', 'uses' => 'AdminController@getActivities'));
    Route::any('/setting', array('as' => 'setting', 'uses' => 'CoreController@setting'));
    Route::any('/setting/update', array('as' => 'setting-update', 'uses' => 'SettingController@update'));
    Route::post('settingStore', array('as' => 'settingStore', 'uses' => 'CoreController@settingStore'));
});
// route for group
//----------account
Route::group(array('prefix' => 'user', 'before' => 'auth'), function () {
    Route::get('/account', array('as' => 'account', 'uses' => 'AccountController@getIndex'));
    Route::post('/account', array('as' => 'updateAccount', 'uses' => 'AccountController@updateAccount'));
    Route::get('/settings', array('as' => 'settings', 'uses' => 'AccountController@getSettings'));
    Route::get('/activities', array('as' => 'accountActivities', 'uses' => 'AccountController@getActivities'));
    Route::get('/profile/{id?}', array('as' => 'profile', 'uses' => 'AccountController@getProfile'));
    Route::get('/notifications', array('as' => 'notifications', 'uses' => 'AccountController@getNotifications'));
});
//----------account
Route::group(array('prefix' => 'notification', 'before' => 'auth'), function () {
    Route::any('/', array('as' => 'notification', 'uses' => 'NotificationController@index'));
    Route::any('/create', array('as' => 'notification-create', 'uses' => 'NotificationController@create'));
});
/* ******\ Code Completed till 10th april */
/* ****** Core Version 2.0 Routes start here */
Route::group(array('prefix' => 'admin/db/', 'before' => 'auth'), function () {
    Route::get('/update', array('as' => 'core-db-update', 'uses' => 'CoreDbController@index'));
});
//----------Group
Route::group(array('prefix' => 'admin/group/', 'before' => 'auth'), function () {
    Route::any('/index', array('as' => 'core-group-index', 'uses' => 'GroupController@index'));
    Route::any('/create', array('as' => 'core-group-create', 'uses' => 'GroupController@create'));
    Route::any('/read/{id?}', array('as' => 'core-group-read', 'uses' => 'GroupController@read'));
    Route::any('/update/{id?}', array('as' => 'core-group-update', 'uses' => 'GroupController@update'));
    Route::any('/delete/{id?}', array('as' => 'core-group-delete', 'uses' => 'GroupController@delete'));
    Route::any('/bulk/action', array('as' => 'core-group-bulk-action', 'uses' => 'GroupController@bulkAction'));
    Route::any('/group/permission/sync', array('as' => 'core-group-permission-sync', 'uses' => 'GroupController@sync'));
    Route::any('/group/permission/toggle', array('as' => 'core-group-permission-toggle', 'uses' => 'GroupController@toggle'));
    Route::get('/groups/{id}/permissions', array('as' => 'core-group-permission', 'uses' => 'GroupController@group_permissions'));
});
//----------Permission
Route::group(array('prefix' => 'admin/permission/', 'before' => 'auth'), function () {
    Route::any('/index', array('as' => 'core-permission-index', 'uses' => 'PermissionController@index'));
    Route::any('/create', array('as' => 'core-permission-create', 'uses' => 'PermissionController@create'));
    Route::any('/read/{id?}', array('as' => 'core-permission-read', 'uses' => 'PermissionController@read'));
    Route::any('/update/{id?}', array('as' => 'core-permission-update', 'uses' => 'PermissionController@update'));
    Route::any('/delete/{id?}', array('as' => 'core-permission-delete', 'uses' => 'PermissionController@delete'));
    Route::any('/bulk/action', array('as' => 'core-permission-bulk-action', 'uses' => 'PermissionController@bulkAction'));
});
//----------Users
Route::group(array('prefix' => 'admin/user/', 'before' => 'auth'), function () {
    Route::any('/index', array('as' => 'core-user-index', 'uses' => 'UserController@index'));
    Route::any('/create', array('as' => 'core-user-create', 'uses' => 'UserController@create'));
    Route::any('/read/{id?}', array('as' => 'core-user-read', 'uses' => 'UserController@read'));
    Route::any('/update/{id?}', array('as' => 'core-user-update', 'uses' => 'UserController@update'));
    Route::any('/delete/{id?}', array('as' => 'core-user-delete', 'uses' => 'UserController@delete'));
    Route::any('/bulk/action', array('as' => 'core-user-bulk-action', 'uses' => 'UserController@bulkAction'));
});


/* ******\ Core Version 2.0 Routes start here */
