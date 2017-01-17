<?php

class CoreDbController extends BaseController
{

    public $data;

    public function __construct()
    {

        $this->data = new stdClass();

        $this->beforeFilter(function () {
            if (!Permission::check('show-admin-section')) {
                $error_message = "You don't have permission to view this page";
                if(isset($this->data->input->format) && $this->data->input->format == "json")
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else
                {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
    }

    //------------------------------------------------------
    public function index()
    {

        $list = get_class_methods('CoreDbController');

        foreach($list as $item)
        {

            if (strpos($item, 'update') !== false)
            {
                CoreDbController::$item();
            }

        }

        echo "<hr/>";
        echo "Execution Completed";


    }
    //------------------------------------------------------

    public function update_2016_01_07_7PM()
    {


        try{

            Schema::table('groups', function($table)
            {
                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('active');

                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');

                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

            });

        } catch(Exception $e)
        {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }



    }

    //------------------------------------------------------
    public function update_2016_01_08_6PM()
    {

        try{
            Schema::table('permissions', function($table)
            {
                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('active');

                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');

                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

            });


        } catch(Exception $e)
        {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }



    }

    //------------------------------------------------------
    public function update_2016_01_08_6_30PM()
    {
        $permissions[] = 'Core Activity Create';
        $permissions[] = 'Core Activity Read';
        $permissions[] = 'Core Activity Update';
        $permissions[] = 'Core Activity Delete';
        $permissions[] = 'Core Manage All Users Activity';

        $permissions[] = 'Core Notification Create';
        $permissions[] = 'Core Notification Read';
        $permissions[] = 'Core Notification Update';
        $permissions[] = 'Core Notification Delete';
        $permissions[] = 'Core All Users Notification';

        $permissions[] = 'Core Permission Create';
        $permissions[] = 'Core Permission Read';
        $permissions[] = 'Core Permission Update';
        $permissions[] = 'Core Permission Delete';

        $permissions[] = 'Core Setting Create';
        $permissions[] = 'Core Setting Read';
        $permissions[] = 'Core Setting Update';
        $permissions[] = 'Core Setting Delete';

        $permissions[] = 'Core User Create';
        $permissions[] = 'Core User Read';
        $permissions[] = 'Core User Update';
        $permissions[] = 'Core User Delete';


        foreach ($permissions as $permission) 
        {
            $input['name'] = $permission;
            $input['slug'] = Str::slug($permission);

            //check if already exist
            $exist = Permission::where('slug', '=', $input['slug'])->first();
            if ($exist) {
                continue;
            }

            $response = Permission::create($input);

            if ($response['status'] == 'failed') {
                return $response;
                die();
            }

        }

        //sync this permission with rest of the groups
        Custom::syncPermissions();
    }
    //------------------------------------------------------
    public function update_2016_01_08_7_30PM()
    {
        try{
            Schema::table('users', function($table)
            {
                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('active');

                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');

                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

            });
        } catch(Exception $e)
        {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }

    //------------------------------------------------------
    public function update_2016_03_11_4PM()
    {
        try{
            User::dbCreateForgotPasswordColumn();
        } catch(Exception $e)
        {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }

    }
    //------------------------------------------------------
    public function update_2016_05_26_1AM()
    {
        try{

            Schema::table('notifications', function($table)
            {
                $table->boolean('realtime')->nullable()->after('read');
            });

        } catch(Exception $e)
        {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }

    }
    //------------------------------------------------------
    //------------------------------------------------------


} // end of the class