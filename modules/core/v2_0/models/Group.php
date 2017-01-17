<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Group extends Eloquent
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
        'name' => 'required|unique:groups',
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
    // this method is called from custom class to synchronize permission and group
    public function permissions($active=NULL)
    {
        $permissions =  $this->belongsToMany('Permission')
                ->withPivot('group_id')
                ->withPivot('permission_id')
                ->withPivot('active')
                ->withPivot('id');
        if($active != NULL)
        {
            $permissions->wherePivot('active', $active);
        }

        return $permissions;
    }

    //------------------------------------------------------------
    public static function count_users($group_id)
    {
        return User::where('group_id', $group_id)->count();
    }
    //------------------------------------------------------------
    public static function getList($current_user_only = false)
    {
        $modelname = __CLASS__;
        $results = Custom::search($modelname, 'name', $current_user_only = false);
        return $results;
    }

    //------------------------------------------------------------
    public function createdBy()
    {
        return $this->belongsTo('User', 'created_by', 'id');
    }
    //------------------------------------------------------------
    public function modifiedBy()
    {
        return $this->belongsTo('User', 'modified_by', 'id');
    }
    //------------------------------------------------------------
    public function deletedBy()
    {
        return $this->belongsTo('User', 'deleted_by', 'id');
    }
    //------------------------------------------------------------

    public static function getGroupList()
    {
        $data = Group::all();
        return json_encode($data);
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
            $item = Group::find($input->id);
            $item->modified_by = Auth::user()->id;
        }
        else
        {
            $validator = Validator::make((array)$input, Group::rules());
            if($validator->fails())
            {
                $response['status'] = 'failed';
                $response['errors'] = $validator->messages()->all();
                return $response;
            }

            $item = new Group();
            $item->slug = Str::slug($input->name);
            $item->created_by = Auth::user()->id;

        }


        $columns = Schema::getColumnListing('groups');

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
    public static function getGroupIdFromSlug($slug)
    {
        $group = Group::where('slug', '=', $slug)->first();

        if(!$group->isEmpty)
        {
            return $group->id;
        } else
        {
            return false;
        }
    }
    //------------------------------------------------------------
    public static function getGroupUsersFromSlug($slug, $format=NULL)
    {
        $group_id = Group::getGroupIdFromSlug($slug);

        if($format == NULL)
        {
            $users = User::where('group_id', $group_id)->get();
        } else if($format == 'array')
        {
            $users = User::where('group_id', $group_id)->get()->toArray();
        }

        return $users;

    }
    //------------------------------------------------------------
    public static function getGroupUsersFromID($group_id, $format=NULL)
    {
        if($format == NULL)
        {
            $users = User::where('group_id', $group_id)->get();
        } else if($format == 'array')
        {
            $users = User::where('group_id', $group_id)->get()->toArray();
        }

        return $users;

    }
    //------------------------------------------------------------
    //------------------------------------------------------------

}