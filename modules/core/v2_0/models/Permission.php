<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Collection;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Permission extends Eloquent
{
    protected $connection = 'mysql';
    /* ****** Code Completed till 10th april */
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected static $rules = array(
        'name' => 'required|min:2|max:50|unique:permissions',
    );

    //------------------------------------------------------------
    public static function rules()
    {
        return [
            'name' => 'required|unique:groups',
        ];
    }

    //------------------------------------------------------------
    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
    }

    //------------------------------------------------------------
    public function groups($active = NULL)
    {
        $groups = $this->belongsToMany('Group')
            ->withPivot('group_id')
            ->withPivot('permission_id')
            ->withPivot('active')
            ->withPivot('id');

        if($active != NULL)
        {
            $groups->wherePivot('active', $active);
        }

        return $groups;
    }

    //------------------------------------------------------------
    public static function store($input=NULL)
    {
        if ($input == NULL) {
            $input = Input::all();
        }

        //remove empty array
        if(is_array($input))
        {
            $input = array_filter($input);
        }

        if (!is_object($input)) {
            $input = (object)$input;
        }

        //if id is provided then find
        if (isset($input->id) && !empty($input->id))
        {
            $item = Permission::find($input->id);
            $item->modified_by = Auth::user()->id;
        }
        else
        {
            $validator = Validator::make((array)$input, Permission::rules());
            if($validator->fails())
            {
                $response['status'] = 'failed';
                $response['errors'] = $validator->messages()->all();
                return $response;
            }

            $item = new Permission();
            $item->slug = Str::slug($input->name);
            $item->created_by = Auth::user()->id;

        }


        $columns = Schema::getColumnListing('permissions');

        foreach($input as $key => $value)
        {
            if(in_array($key, $columns))
            {
                if($key == 'name')
                {
                    $item->$key = ucwords($value);
                } else
                {
                    $item->$key = $value;
                }

            }
        }

        try{
            $item->save();
            $response['status'] = 'success';
            $response['data'] = $item;

        } catch(Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return $response;

    }

    //------------------------------------------------------------
    public static function userList($permission_slug, $admin=true)
    {
        $permission = Permission::where('slug', '=', $permission_slug)->first();

        //find all groups which has this permission and permission is active to the group
        $groups = $permission->groups('1')->get();

        $group_ids = array();
        if($groups)
        {
            foreach($groups as $group)
            {
                $group_ids[] = $group->id;
            }
        }

        if($admin == true)
        {
            $admin_group = Group::where('slug', '=', 'admin')->first();

            if(!in_array($admin_group->id, $group_ids))
            {
                $group_ids[] = $admin_group->id;
            }
        }

        $users = User::where('group_id', $group_ids)->get();

        return $users;

    }
    //------------------------------------------------------------
    public static function getList($current_user_only = false)
    {
        $modelname = __CLASS__;
        $results = Custom::search($modelname, 'name', $current_user_only = false);
        return $results;
    }

    //------------------------------------------------------------
    public static function check($permission_slug, $user_id = NULL)
    {

        //if permission does not exist then create one
        $find_or_create = Permission::where('slug', '=', $permission_slug)->first();

        if(!$find_or_create)
        {
            $find_or_create = new Permission();
            $find_or_create->slug = $permission_slug;
            $find_or_create->name = ucwords(str_replace("-", " ", $permission_slug));
            $find_or_create->save();
            Custom::syncPermissions();
        }
        if($user_id == NULL)
        {
            if(isset(Auth::user()->id))
            {
                $user_id = Auth::user()->id;
            }
        }

        if(!isset($user_id) || $user_id == NULL)
        {
            return false;
        }

        $user = User::find($user_id);

        $group_id = $user->group_id;
        /* if user belong to admin & active then permission slug will not matter */
        $group = Group::find($group_id);
        if ($group->slug == 'admin') {
            //check user is active
            if ($user->active == 0) {
                return false;
            } else {
                return true;
            }
        }
        /* end of only in case of admin */
        $permission_d = Permission::where('slug', '=', $permission_slug)->first();
        if (count($permission_d) < 1) {
            return false;
        }
        $permission = Group::find($group_id)->permissions()->wherePivot('permission_id', $permission_d->id)->get();
        if ($permission[0]->pivot->active == 0) {
            return false;
        } else if ($permission[0]->pivot->active == 1) {
            return true;
        }
    }

    //------------------------------------------------------------
    public static function users_have_permission($slug, $exclude_current_user = true)
    {
        $permission = Permission::where('slug', '=', $slug)->first();
        if(!$permission)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'permission slug does not exist';
            return $response;
        }

        //find all the group which has this permission active
        $groups = $permission->groups(1)->get();


        if(!$groups)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'no group has this permission as active';
            return $response;
        }

        $group_id = array();
        foreach($groups as $group)
        {
            $group_id[] = $group->id;
        }

        $users = User::whereIn('group_id', $group_id)->where('active', 1);

        if($exclude_current_user == true)
        {
            $users->where('id', "!=", Auth::user()->id);
        }

        $list = $users->get();


        return $list;
    }

    //------------------------------------------------------------
    public static function users_have_permission_email_array($permission_slug, $exclude_current_user = true)
    {
        $users = Permission::users_have_permission($permission_slug);

        if(!empty($users))
        {
            foreach($users as $user)
            {
                if($exclude_current_user == true)
                {
                    if( $user->id != Auth::user()->id)
                    {
                        $to[] = $user->email;
                    }
                } else
                {
                    $to[] = $user->email;
                }

            }

            return $to;
        } else
        {
            return false;
        }

    }
    //------------------------------------------------------------
    /* ******\ Code Completed till 10th april */
} //end of the class