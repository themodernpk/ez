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

    $permissions[] = 'Ease';

    $permissions[] = 'Ease Country Create';
    $permissions[] = 'Ease Country Read';
    $permissions[] = 'Ease Country Update';
    $permissions[] = 'Ease Country Delete';
    //faq
    $permissions[] = 'Ease Faq Create';
    $permissions[] = 'Ease Faq Read';
    $permissions[] = 'Ease Faq Update';
    $permissions[] = 'Ease Faq Delete';
    //services
    $permissions[] = 'Ease Service Create';
    $permissions[] = 'Ease Service Read';
    $permissions[] = 'Ease Service Update';
    $permissions[] = 'Ease Service Delete';
    //terms and conditions
    $permissions[] = 'Ease Tnc Create';
    $permissions[] = 'Ease Tnc Read';
    $permissions[] = 'Ease Tnc Update';
    $permissions[] = 'Ease Tnc Delete';
    //offer
    $permissions[] = 'Ease Offer Create';
    $permissions[] = 'Ease Offer Read';
    $permissions[] = 'Ease Offer Update';
    $permissions[] = 'Ease Offer Delete';
    //coupon
    $permissions[] = 'Ease Coupon Create';
    $permissions[] = 'Ease Coupon Read';
    $permissions[] = 'Ease Coupon Update';
    $permissions[] = 'Ease Coupon Delete';
    //professional level
    $permissions[] = 'Ease ProfessionLevel Create';
    $permissions[] = 'Ease ProfessionLevel Read';
    $permissions[] = 'Ease ProfessionLevel Update';
    $permissions[] = 'Ease ProfessionLevel Delete';
    //seekers
    $permissions[] = 'Ease Seeker Create';
    $permissions[] = 'Ease Seeker Read';
    $permissions[] = 'Ease Seeker Update';
    $permissions[] = 'Ease Seeker Delete';
    //provider
    $permissions[] = 'Ease Provider Create';
    $permissions[] = 'Ease Provider Read';
    $permissions[] = 'Ease Provider Update';
    $permissions[] = 'Ease Provider Delete';
    //Support Desk
    $permissions[] = 'Ease SupportDesk Create';
    $permissions[] = 'Ease SupportDesk Read';
    $permissions[] = 'Ease SupportDesk Update';
    $permissions[] = 'Ease SupportDesk Delete';
    //ReportedIssues
    $permissions[] = 'Ease ReportIssue Create';
    $permissions[] = 'Ease ReportIssue Read';
    $permissions[] = 'Ease ReportIssue Update';
    $permissions[] = 'Ease ReportIssue Delete';
    //Pyament
    $permissions[] = 'Ease Payment Create';
    $permissions[] = 'Ease Payment Read';
    $permissions[] = 'Ease Payment Update';
    $permissions[] = 'Ease Payment Delete';
    //Reviews
    $permissions[] = 'Ease Reviews Create';
    $permissions[] = 'Ease Reviews Read';
    $permissions[] = 'Ease Reviews Update';
    $permissions[] = 'Ease Reviews Delete';
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
    $connection="mongodb";
    Schema::connection($connection)->create('ease_countries', function ($table) {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
        $table->integer('created_by')->unsigned()->nullable();
        $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('slug');
        $table->integer('modified_by')->unsigned()->nullable();
        $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
        $table->integer('deleted_by')->unsigned()->nullable();
        $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

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
    Schema::connection($connection)->dropIfExists('ease_countries');
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
