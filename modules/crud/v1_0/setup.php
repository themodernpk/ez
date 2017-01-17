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
    $response['status'] = 'success';
    return $response;
}

//------------------------------------------------------
//------------------------------------------------------
function permissionList()
{
    $permissions[] = 'Crud Create';
    $permissions[] = 'Crud Read';
    $permissions[] = 'Crud Update';
    $permissions[] = 'Crud Delete';
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
    $connection = 'mysql';
    Schema::connection($connection)->create('cruds', function ($table) {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
        $table->boolean('enable')->default(0);
        $table->integer('created_by')->nullable();
        $table->integer('modified_by')->nullable();
        $table->integer('deleted_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
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
    $connection = 'mysql';
    Schema::connection($connection)->dropIfExists('cruds');
    $response['status'] = 'success';
    return $response;
}

//------------------------------------------------------
function createGroup()
{
    $list = groupList();
    if (count($list) > 0) {
        foreach ($list as $item) {
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
