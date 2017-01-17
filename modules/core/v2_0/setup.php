<?php

//------------------------------------------------------
function install()
{

    //you may need new permissions which belongs only to your application
    $response = createPermissions();
    if ($response['status'] == 'failed') {
        return $response;
    }

    $response = createGroup();
    if ($response['status'] == 'failed') {
        return $response;
    }

    //Run migrations
    migrations();

    //run seeds
    seeds();

    //all remaining db updates
    $extractor = new CoreExtractor();
    $url = URL::route('core-db-update');
    $extractor->LoadCURLPage($url);

    $response['status'] = 'success';

    return $response;
}

//------------------------------------------------------

//------------------------------------------------------
function permissionList()
{

    $permissions[] = 'Allow Dashboard Activity Log';
    $permissions[] = 'Allow Login';
    $permissions[] = 'API Access';
    $permissions[] = 'Show Admin Section';

    $permissions[] = 'Core Group Create';
    $permissions[] = 'Core Group Read';
    $permissions[] = 'Core Group Update';
    $permissions[] = 'Core Group Delete';
    $permissions[] = 'Core Manage Group Permissions';

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


    return $permissions;
}

//------------------------------------------------------
function groupList()
{
    /*$list[] = 'Clients';
    $list[] = 'Imap';
    $list[] = 'Spam';

    return $list;*/
}

//------------------------------------------------------
function migrations()
{

}

//------------------------------------------------------

function seeds()
{
    $response['status'] = 'success';
    return $response;
}

//------------------------------------------------------
function uninstall()
{
    //delete permission of for this module
    deletePermissions();

    //drop tables

    $response['status'] = 'success';

    return $response;
}
//------------------------------------------------------

function createGroup()
{

    $list = groupList();

    if(count($list) > 0)
    {
        foreach ($list as $item)
        {
            $input['name'] = $item;
            $input['slug'] = Str::slug($item);

            //check if already exist
            $exist = Group::where('slug', '=', $input['slug'])->first();
            if ($exist) {
                continue;
            }

            $response = Group::create($input);

            if ($response['status'] == 'failed') {
                return $response;
                die();
            }

        }

        //sync this permission with rest of the groups
        Custom::syncPermissions();
    }


    $response['status'] = 'success';
    return $response;

}
//------------------------------------------------------
//------------------------------------------------------

function createPermissions()
{

    $permissions = permissionList();

    foreach ($permissions as $permission) {
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

    $response['status'] = 'success';
    return $response;


}

//------------------------------------------------------
//------------------------------------------------------

function deletePermissions()
{
    $permissions = permissionList();

    foreach ($permissions as $permission) {
        $slug = Str::slug($permission);
        Permission::where('slug', '=', $slug)->forceDelete();
    }

}

//------------------------------------------------------

function upgrade($active_vesion)
{

    //upgrades code can very for differrent last version
    switch ($active_vesion) {
        case 1.0:

            //install new permissions
            $response = createPermissions();
            if ($response['status'] == 'failed') {
                return $response;
            }

            $response = createGroup();
            if ($response['status'] == 'failed') {
                return $response;
            }

            //Run migrations
            migrations();

            //run seeds
            seeds();

            $response['status'] = 'success';

            return $response;

            break;
        //----------------------------------------------
        case 1.1:

            break;
        //----------------------------------------------
        //----------------------------------------------
        //----------------------------------------------

    }

}

//------------------------------------------------------

//------------------------------------------------------
//------------------------------------------------------
//------------------------------------------------------
//------------------------------------------------------
