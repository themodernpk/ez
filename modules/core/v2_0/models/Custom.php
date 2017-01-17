<?php
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Custom
{
    protected $connection = 'mysql';
     //------------------------------------------------------------
    public static function syncPermissions()
    {
        $fetch_groups = Group::all();
        $fetch_permissions = Permission::all();
        $groups = DB::table('groups')->lists('id');
        $permissions = DB::table('permissions')->lists('id');

        foreach ($fetch_permissions as $item) {
            $permission = Permission::find($item->id);
            //we are trying to sync all the groups with existing permission
            $permission->groups()->sync($groups);
        }

        foreach ($fetch_groups as $item)
        {
            $group = Group::find($item->id);


            if($group->slug == 'admin')
            {
                foreach($fetch_permissions as $permission)
                {
                    $update_permissions[$permission->id] = array('active' => 1);
                }
                $group->permissions()->sync($update_permissions);

            } else
            {
                $group->permissions()->sync($permissions);
            }


        }



    }

    //------------------------------------------------------------

    /* ******\ Code Completed till 10th april */
}