<?php
/**
 * Created by PhpStorm.
 * User: pradeep
 * Date: 2014-12-14
 * Time: 03:21 PM
 */

class PermissionsTableSeeder extends Seeder
{

    public function run()
    {
        
        $permissions[] = 'Allow Dashboard Activity Log';
        $permissions[] = 'Show Admin Section';
        $permissions[] = 'API Access';
        $permissions[] = 'Allow Login';

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

}