<?php
function scan_dir_paths($dir)
{
    $contents = array();
    foreach (scandir($dir) as $file) {
        if ($file == '.' || $file == '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            $do = scan_dir_paths($path);
            $contents = array_merge($contents, $do);
        } else {
            $contents[] = $path;
        }
    }
    return $contents;
}

//-------------------------------------------------------------
function modules_path($module_name = NULL)
{
    $path = base_path() . "/.." . "/modules";
    if ($module_name != NULL) {
        $path .= "/" . $module_name;
    }
    return $path;
}

//-------------------------------------------------------------
function modules_list()
{
    if (Session::get('modules_table')) {
        //core will be loaded by default while remaining will be searched from database
        $count = DB::table('modules')->where('active', '=', 1)->count();
    } else {
        $count = 0;
    }
    if ($count > 0) {
        $modules = DB::table('modules')->select('name')->where('active', '=', 1)->get();
        foreach ($modules as $module) {
            $item[] = $module->name;
        }
        $modules = $item;
    } else {
        $modules = array('core');
    }
    return $modules;
}

//-------------------------------------------------------------
function modules_scan()
{
    $modules_path = modules_path();
    $folders = list_sub_folders($modules_path);
    foreach ($folders as $item) {
        $modules[] = str_replace($modules_path . "/", "", $item);
    }
    return $modules;
}

//-------------------------------------------------------------
function list_sub_folders($path, $dir_name = false)
{
    $folders = array_filter(glob($path . "/*"), 'is_dir');
    if (count($folders) < 1) {
        return false;
    }
    if ($dir_name == false) {
        return $folders;
    }
    if ($dir_name == true) {
        foreach ($folders as $folder) {
            $dir_names[] = str_replace($path . "/", "", $folder);
        }
        return $dir_names;
    }
}

//-------------------------------------------------------------
function module_versions_list($module_name)
{
    $module_path = modules_path($module_name);
    $version = list_sub_folders($module_path, true);
    return $version;
}

//-------------------------------------------------------------
function module_current_version($module_name)
{
    if (Session::get('modules_table')) {
        $module = DB::table('modules')->select('version')
            ->where('name', '=', $module_name)
            ->where('active', '=', 1)->first();
        if ($module) {
            return $module->version;
        } else if ($module_name == "core") {
            $version = array_reverse(module_versions_list($module_name));
            $version = str_replace('v', '', $version[0]);
            $version = str_replace('_', '.', $version);
            return $version;
        }
    } else {
        $version = array_reverse(module_versions_list($module_name));
        $version = str_replace('v', '', $version[0]);
        $version = str_replace('_', '.', $version);
        return $version;
    }
}

//-------------------------------------------------------------
function module_current_version_path($module_name)
{
    $module_path = modules_path($module_name);
    $current_version = "v" . str_replace(".", "_", module_current_version($module_name));
    $path = $module_path . "/" . $current_version;
    return $path;
}

//-------------------------------------------------------------
function get_moduel_name($current_path)
{
    $name = str_replace(module_path() . '\modules', "", $current_path);
    $name = explode('\\', $name);
    return $name[1];
}

//-------------------------------------------------------------
//-------------------------------------------------------------