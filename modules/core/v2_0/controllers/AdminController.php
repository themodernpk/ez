<?php

class AdminController extends BaseController
{
    /* ****** Code Completed till 10th april */
    public static $view = 'core::admin.core-admin';
    var $input;

    /* #################################
     * This is constructor
     * We use 'beforeFilter' function in this constructor
     * 'Redirect' does not work in 'constructor', if we don't use 'beforeFilter'
     * #################################
     */
    public function __construct()
    {
        $this->input = Input::all();
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
    /* #################################
     * This method is defined to perform Bulk Action on following tables
     * "Group/Permission/User " tables
     * We perform 'Activate/DeActivate/Soft Delete/permanent delete/restore' operation in bulk
     * Based on our action we perform operation using 'switch' concept
     * We have multiple submit button in the form , name of each button is 'action'
     * So, We use $input['action'], gives the 'value' of submit button which is 'clicked'
     * In the 'value' attribute of submit button , what 'action' to be performed is defined
     * We get table name from hidden field of button
     * Our table name is in 'encrypted' form 'Decrypt' it. and get the model for this table
     * Use 'get_model_from_table' function to get table name ,defined in 'helpers/function.php'
     * Before performing ny action we 'log' the activity..which is stored in activity table
     * The 'log' method is defined in Activity Model
     * #################################
     */
    public function bulkAction()
    {
        $input = Input::all();
        // get table name from hidden field
        // this will be in encrypted form
        $input['table'] = Crypt::decrypt($input['table']);
        $model_name = get_model_from_table($input['table']);
        $rules = array('table' => "required|min:3", 'action' => "required");
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        //check ids are set
        if (!isset($input['id']) || !is_array($input['id']) || empty($input['id'])) {
            return Redirect::back()->with('flash_error', "Select check boxes to perform action");
        }
        //Action Can't be performed on Admin
        foreach ($input['id'] as $id) {

            if(!core_settings($input['table'])['exceptions'])
            {
                continue;
            }

            if (in_array($id, core_settings($input['table'])['exceptions'])) {
                return Redirect::back()->with('flash_warning', 'Action cannot be performed');
            }
        }
        // get the action to be performed from 'submit' button's attribute name
        // $input['action'] return the value of 'submit' button which is 'action'
        //perform action according to that
        switch ($input['action']) {
            case 'active':
                try {
                    foreach ($input['id'] as $id) {
                        $model = $model_name::find($id);
                        $model->active = 1;
                        $model->save();
                        Activity::log($model_name . " - Activated, '" . $model->name . "' ", Auth::user()->id, 'Activated', $input['table'], $model->id);
                    }
                    return Redirect::back()->with('flash_success', constant('core_success'));
                } catch (\Exception $e) {
                    return Redirect::back()->with('flash_error', $e->getMessage());
                }
                break;
            //------------------------------
            case 'deactive':
                try {
                    foreach ($input['id'] as $id) {
                        $model = $model_name::find($id);
                        $model->active = 0;
                        $model->save();
                        Activity::log($model_name . " - Deactivated, '" . $model->name . "' ", Auth::user()->id, 'Deactivated', $input['table'], $model->id);
                    }
                    return Redirect::back()->with('flash_success', constant('core_success'));
                } catch (\Exception $e) {
                    return Redirect::back()->with('flash_error', $e->getMessage());
                }
                break;
            //------------------------------
            case 'delete':
                try {
                    foreach ($input['id'] as $id) {
                        $model = $model_name::find($id);
                        $model->deleted_at = date('Y-m-d H:i:s');
                        $model->save();
                        Activity::log($model_name . " - Deleted, '" . $model->name . "' ", Auth::user()->id, 'Deleted', $input['table'], $model->id);
                    }
                    return Redirect::back()->with('flash_success', constant('core_success'));
                } catch (\Exception $e) {
                    return Redirect::back()->with('flash_error', $e->getMessage());
                }
                break;
            //------------------------------
            case 'restore':
                try {
                    foreach ($input['id'] as $id) {
                        $model = $model_name::withTrashed()->where('id', $id)->restore();
                        Activity::log($model_name . " - Restored, '" . $model_name::findOrFail($id)->name . "' ", Auth::user()->id, 'Restored', $input['table'], $id);
                    }
                    return Redirect::back()->with('flash_success', constant('core_success'));
                } catch (\Exception $e) {
                    return Redirect::back()->with('flash_error', $e->getMessage());
                }
                break;
            //------------------------------
            case 'forcedelete':
                try {
                    foreach ($input['selctedname'] as $name) {
                        Activity::log($model_name . " - permanentdeleted, '" . $name . "' ", Auth::user()->id, 'ForceDeleted', $input['table'], '');
                    }
                    foreach ($input['id'] as $id) {
                        $model = $model_name::withTrashed()->where('id', $id)->forceDelete();
                    }
                    return Redirect::back()->with('flash_success', constant('core_success'));
                } catch (\Exception $e) {
                    return Redirect::back()->with('flash_error', $e->getMessage());
                }
                break;
            //---------------------------------
            default:
                return Redirect::back()->with('flash_warning', "No action to perform.");
                break;
        }
    }



    //------------------------------------------------------
    function getModules()
    {
        $this->beforeFilter(function () {
            if (!Permission::check('admin')) {
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
        $path = base_path() . "/.." . "/modules";
        $module_list = list_sub_folders($path, true);
        $i = 0;
        foreach ($module_list as $module) {
            /*            if($item == 'core' || $item == 'acl')
                        {
                            continue;
                        }*/
            $list[$i]['name'] = $module;
            $details_xml = modules_path($module) . "/details.xml";
            if (!file_exists($details_xml)) {
                $details = "details.xml does not exist";
            } else {
                $details = simplexml_load_file($details_xml);
            }
            $list[$i]['details'] = $details;
            $versions = module_versions_list($module);
            foreach ($versions as $ver) {
                $ver_xml = modules_path($module) . "/" . str_replace(".", "_", $ver) . "/version.xml";
                $ver_num = str_replace("_", ".", $ver);
                $ver_num = str_replace("v", "", $ver_num);
                if (!file_exists($ver_xml)) {
                    $details = "version.xml does not exist";
                } else {
                    $details = simplexml_load_file($ver_xml);
                }
                $list[$i]['versions'][$ver_num] = $details;
            }
            ksort($list[$i]['versions']);
            $list[$i]['versions'] = array_reverse($list[$i]['versions']);
            //check if any version is already installed
            $active = Module::select('version')->where('name', '=', $module)->where('active', '=', 1)->first();
            if ($active) {
                $list[$i]['active'] = $active;
            }
            $i++;
        }
        $data['list'] = $list;
        return View::make(self::$view . '-modules')->with('title', 'All Modules')->with('data', $data);
    }

    //------------------------------------------------------
    function moduleInstall()
    {
        if (!Permission::check('allow-admin-modules')) {
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
        $input = Input::all();
        //load helper
        $ver_folder = 'v' . str_replace(".", "_", $input['version']);
        $class_path = modules_path($input['name']) . "/" . $ver_folder . "/setup.php";
        if (!File::exists($class_path)) {
            echo "Installation helper file does not exist at " . $class_path;
            die();
        } else {
            //echo $class_path;
            include_once($class_path);
        }
        if ($input['task'] == 'install') {
            //check if current version is already active or installed
            $exist = Module::where('name', '=', $input['name'])->where('version', '=', $input['version'])->first();
            if ($exist) {
                echo "This module version is already installed";
                die();
            }
            //mark all existing dabase version as deactive
            Module::where('name', '=', $input['name'])->forceDelete();
            $response = install();
            if ($response['status'] == 'success') {
                $module = new Module();
                $module->name = $input['name'];
                $module->version = $input['version'];
                $module->active = 1;
                $module->save();
                echo "ok";
            } else {
                echo json_decode($response);
            }
        } //------------------------------------------------------
        else if ($input['task'] == 'uninstall') {
            $response = uninstall();
            if ($response['status'] == 'success') {
                Module::where('name', '=', $input['name'])->forceDelete();
                echo "ok";
            } else {
                echo json_decode($response);
            }
        } //------------------------------------------------------
        else if ($input['task'] == 'upgrade') {
            $response = upgrade($input['active_version']);
            if ($response['status'] == 'success') {
                Module::where('name', '=', $input['name'])->forceDelete();
                $module = new Module();
                $module->name = $input['name'];
                $module->version = $input['version'];
                $module->active = 1;
                $module->save();
                echo "ok";
            } else {
                echo json_decode($response);
            }
        }
    }


    //------------------------------------------------------
    /* #################################
    * This method is defined to list all Activities performed
    * We use Activity model to do this
    * Result is displayed in 'core-admin-dashboard.activity.php'
    * This method also displays the activity based on 'date' selection
    * #################################
    */
    function getActivities()
    {
        if (!Permission::check('view-activities')) {
            return Redirect::route('error')->with('flash_error', constant('core_msg_permission_denied'));
        }
        $input = Input::all();
        //if start and end is set
        if (Input::has('start') && Input::has('end')) {
            $data['list'] = Activity::whereBetween('created_at', array($input['start'], $input['end']))->get();
        } else {
            $data['list'] = Activity::all();
        }

        if(isset($this->input['apirequest']))
        {
            Switch($this->input['apirequest'])
            {
                case 'json':
                    $response = array('status' => 'success', 'data' => $data['list']);
                    return json_encode($response);
                    break;
            }
        }
        return View::make(self::$view . '-activity')->with('title', 'All Activity Log')->with('data', $data);
    }



} // end of class