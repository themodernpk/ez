<?php

class SetupController extends BaseController
{
    /* ****** Code Completed till 10th april */
    public static $view = 'core::setup.core-setup';

    function __construct()
    {
        $this->stepVerification();
    }

    //--------------------------------------------------
    public function getIndex()
    {
        $data = array();
        return View::make(self::$view . '-dbconnection')->with('title', 'Step 1: Setup -> Setup This Application')->with('data', $data);
    }

    //--------------------------------------------------
    function setupPost()
    {
        $input = Input::all();
        $host = $input['hostname'];
        $dbuser = $input['dbuser'];
        $dbpass = $input['dbpass'];
        $dbname = $input['dbname'];
        try {
            mysqli_connect($host, $dbuser, $dbpass, $dbname);
            if (mysqli_connect_errno()) {
                return Redirect::route('setup')->with('flash_error', mysqli_connect_error())->withInput();
            } else {
                try {
                    //check blank database file exist else consider database.php
                    $path_blank = app_path() . '\config\database_blank.php';
                    if (!file_exists($path_blank)) {
                        $path_blank = app_path() . '\config\database.php';
                    }
                    $path_config = app_path() . '\config\database.php';
                    $config = file_get_contents($path_blank);
                    $config = str_replace("'host'      => '',", "'host'      => '{$host}',", $config);
                    $config = str_replace("'database'  => '',", "'database'  => '{$dbname}',", $config);
                    $config = str_replace("'username'  => '',", "'username'  => '{$dbuser}',", $config);
                    $config = str_replace("'password'  => '',", "'password'  => '{$dbpass}',", $config);
                    file_put_contents($path_config, $config);
                    return Redirect::route('migrations');
                } catch (Exception $e) {
                    return Redirect::route('setup')->with('flash_error', $e->getMessage())->withInput();
                }
            }
        } catch (Exception $e) {
            return Redirect::route('setup')->with('flash_error', $e->getMessage())->withInput();
        }
    }

    //--------------------------------------------------
    function migrationsAndSeeds()
    {
        $data = array();
        return View::make(self::$view . '-migration')->with('title', 'Step 2: Setup -> Run Migrations')->with('data', $data);
    }

    //--------------------------------------------------
    function migrationsAndSeedsRun()
    {
        $input = Input::all();
        try {
            if (!Schema::hasTable('migrations')) {
                Artisan::call('migrate:install');
                Artisan::call('migrate');
                /*activate current version of core*/
                $current_version_core = module_current_version('core');
                $items = [
                    ['name' => 'core',
                        'version' => $current_version_core,
                        'active' => 1,
                        'created_at' => Dates::now(),
                        'updated_at' => Dates::now(),
                    ]
                ];
                DB::table('modules')->insert($items);
                /*activate current version of core*/
                Artisan::call('db:seed');
            } else {
                Artisan::call('migrate:refresh');
                Artisan::call('db:seed');
            }
            if (isset($input['ajax'])) {
                echo "ok";
            } else {
                return Redirect::route('seeds');
            }
        } catch (Exception $e) {
            if (isset($input['ajax'])) {
                echo $e->getMessage();
            } else {
                return Redirect::route('migrationsAndSeeds')->with('flash_error', $e->getMessage());
            }
        }
    }

    //--------------------------------------------------
    function createAdmin()
    {
        $data = array();
        return View::make(self::$view . '-adminCreate')->with('title', 'Step 3: Setup -> Create Admin User')->with('data', $data);
    }

    //--------------------------------------------------
    function stepVerification()
    {
        $route_name = Route::currentRouteName();
        //does application able to connect with db
        if ($route_name != "setup") {
            if (!DB::connection()->getDatabaseName()) {
                Redirect::route('setup')->with('flash_warning', "Enter correct database credentials")->send();
            }
        } else {
            if (DB::connection()->getDatabaseName()) {
                Redirect::route('migrationsAndSeeds')->send();
            }
        }
        //does migration exist
        if ($route_name == "migrationsAndSeeds") {
            if (!DB::connection()->getDatabaseName()) {
                Redirect::route('setup')->with('flash_warning', "Enter correct database credentials")->send();
            }
            //if migration table && admin group exist then move step 3
            $migration_table = Schema::hasTable('migrations');
            if ($migration_table) {
                $group = DB::table('groups')->where('slug', '=', 'admin')->first();
                if ($group) {
                    Redirect::route('createAdmin')->with('flash_warning', "Create admin user")->send();
                }
            }
        }
        //does data exsit in table
        if ($route_name == "createAdmin") {
            if (!DB::connection()->getDatabaseName()) {
                Redirect::route('setup')->with('flash_warning', "Enter correct database credentials")->send();
            }
            $migration_table = Schema::hasTable('migrations');
            $groups_table = Schema::hasTable('groups');
            if (!$migration_table || !$groups_table) {
                Redirect::route('migrationsAndSeeds')->with('flash_warning', "Required tables & data are missing, run the migrations & seeds")->send();
            } else {
                $group = DB::table('groups')->where('slug', '=', 'admin')->first();
                if (!$group) {
                    Redirect::route('migrationsAndSeeds')->with('flash_warning', "Required tables & data are missing, run the migrations & seeds")->send();
                }
                $users = DB::table('users')->where('group_id', '=', $group->id)->first();
                if ($users) {
                    Redirect::route('login')->with('flash_info', "Admin user already exist, please login")->send();
                }
            }
        }
    }

    //--------------------------------------------------
    /* ******\ Code Completed till 10th april */
}
