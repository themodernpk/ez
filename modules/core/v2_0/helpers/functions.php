<?php

/* ****** Code Completed till 10th april */
function asset_path($module_name = "core")
{
    $asset_url = asset("");
    $module_ver = module_current_version($module_name);
    $module_ver = "v" . str_replace(".", "_", $module_ver);
    $asset_path = "modules/" . $module_name . "/" . $module_ver . "/assets";
    return $asset_url . $asset_path;
}

//-----------------------------------------------------------
function findExtension($filename)
{
    $filename = strtolower($filename);
    $exts = explode(".", $filename);
    $n = count($exts) - 1;
    $exts = $exts[$n];
    return $exts;
}

//-----------------------------------------------------------
function body_class()
{
    $body_classes = [];
    $class = "";
    foreach (Request::segments() as $segment) {
        if (is_numeric($segment) || empty($segment)) {
            continue;
        }
        $class .= !empty($class) ? "-" . $segment : $segment;
        array_push($body_classes, $class);
    }
    return !empty($body_classes) ? implode(' ', $body_classes) : "home";
}

//-----------------------------------------------------------
function breadcrumb()
{
    $html = "";
    $html .= '<li><a href="' . route('dashboard') . '">Dashboard</a></li>';
    foreach (Request::segments() as $segment) {
        if (is_numeric($segment) || empty($segment)) {
            continue;
        }
        if ($segment == 'dashboard') {
            continue;
        }
        if (Route::has($segment)) {
            $html .= '<li><a href="' . route($segment) . '">' . ucfirst($segment) . '</a></li>';
        }
    }
    return $html;
}

//-------------------------------------------------------
/* #################################
 * This function returns table name in encrypted format to perform bulkAction
 * We assume that if $table is null ,then second segment of url will be table
 * get the table from url, to do that get the second segment from url
 * Use Request::segment($uri_segment) , gives the table name
 * get table name in encrypted format, Decrypt it and return it
 * #################################
 */
function get_table_name($uri_segment = 2, $table = NULL)
{
    if ($table == NULL) {
        $table = Request::segment($uri_segment);
    }
    $encoded_name = Crypt::encrypt($table);
    return $encoded_name;
}

//-----------------------------------------------------------
/* #################################
 * This function returns Model name when we pass table name as a function arguments
 * There are two rules that should be followed Strictly
 * 1) Table name should be plural
 * 2) Model name should be singular, Starts with capital letter
 * TODO: Bug: This function will not work for table names like "Utiliti",multi", "pakies" etc
 * #################################
 */
function get_model_from_table($table)
{
    /* #################################
     * @$table is argument , it holds table name ,of which model name is required
     * Valid only for tables like, users, groups, permissions etc
     * remove the last letter
     * make the first letter
     * checks if model exist then return it ,then code below this if will then not executed
     * examples: from "users" table, we get "User" Model
     * #################################
     */
    $table_name = substr($table, 0, -1);
    $class_name = ucfirst($table_name);
    if (class_exists($class_name)) {
        return $class_name;
    }
    /* #################################
    * if the above condtion fails then it will execute
    * this code is to get model from table "activities". its model will be "Activity"
    * first get the last three letter of table and check it ends with "ies",
    * if yes then ,remove the last three character of table and add "y" in end.
    * capitalize the first letter and return it
    * #################################
    */
    $last_three = substr($table, -3);
    if ($last_three == "ies") {
        $class_name = ucfirst(substr($table, 0, -3) . "y");
        if (class_exists($class_name)) {
            return $class_name;
        }
    }
}

//-----------------------------------------------------------
/* #################################
 * This function returns exceptions which is already defined  
 * Before performing any operation like delete/activate etc 
 * This function Checks Whether there is any Exception or not 
 * This function returns a array which is the Exception defined in setting.php file
 * @setting.php resides in helpers directory
 * To Access Setting use Config::get('arg1') function 
 * @arg1 is name of setting ,which is alredy defined for exceptional case
 * #################################
 */
function core_settings($key)
{
    // get the setting in array format
    $settings = Config::get('core.settings');

    if(!isset($settings[$key]))
    {
        return false;
    }
    return $settings[$key];
}

//--------------------------------------------------

/* ******\ Code Completed till 10th april */

