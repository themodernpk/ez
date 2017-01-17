<?php

\Debugbar::disable();

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path() . '/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function (Exception $exception, $code) {
    Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function () {
    return Response::make("Be right back!", 503);
});

//this will handle findorFail request, if fails then it will return 404 error
App::error(function (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    return View::make('core::error.error404');
});



/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path() . '/filters.php';


/************************** custom code written by Pradeep **************************/
Session::forget('modules_table');
Session::put('modules_table', Schema::hasTable('modules'));



require app_path() . '/helpers.php';



// code to autoload all the neccessory classes
$modules_list = modules_list();


foreach ($modules_list as $module_name) {

    $current_version = module_current_version($module_name);
    $current_version_path = module_current_version_path($module_name);

    $content = scan_dir_paths($current_version_path);

    if (is_array($content) && empty($content)) {
        continue;
    }

    // autoload all the classes
    foreach ($content as $item) {
        //include classes
        if (strpos($item, 'routes') !== false
            || strpos($item, 'controllers') !== false
            || strpos($item, 'library') !== false
            || strpos($item, 'models') !== false
            || strpos($item, 'helpers') !== false

        ) {
            //echo $item; echo "<br/>";
            include_once($item);

        }

    }



    // declare views
    $module_view_path = $current_version_path . '/views';

    // echo $module_view_path;

    View::addNamespace($module_name, $module_view_path);

    //echo die("<hr/>Die Here");

}




/************************** custom code written by Pradeep **************************/



