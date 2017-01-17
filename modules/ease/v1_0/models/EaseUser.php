<?php
//use Illuminate\Database\Eloquent\SoftDeletingTrait;
//using jenssengers orm and SoftDeletingTrait
use Jenssegers\Mongodb\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class EaseUser extends Eloquent
{
    protected $connection = 'mongodb';
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $fillable = [
        'user_id',
        'verified',
        'gender',
        'rating',
        'wallet',
        'nationality',
        'number_of_reviews',
        'national_iqama_id',
        'email_verification_code',
        'mobile_verification_code',
        'email_status',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'modified_at',
        'deleted_at',
    ];
    public static $prefix = 'easeuser';
    public static $table_name = 'ease_users';
    public static $model = 'EaseUser';
    public static $view = 'ease::user.';
    public static $rows = 25;
    public static $enable = false;
    public static $executor = true;
    //------------------------------------------------------------
    //------------------------------------------------------------
    public static function create_rules()
    {
        return [
            'user_id' => 'required',
        ];
    }
    //------------------------------------------------------------
    public function ease_services() {
        return $this->hasMany('App\EaseService');
    }
    //------------------------------------------------------------
    public static function update_rules()
    {
        return [
            '_id' => 'required',
        ];
    }
    //-----------------------------------------------------------
    public function user() {
        return $this->belongsTo('App\User');
    }
    //------------------------------------------------------------
    //-----------------------------------------------------------
    public function seekers() {
        return $this->hasMany('App\Seeker');
    }
    //------------------------------------------------------------
    //-----------------------------------------------------------
    public function ease_support() {
        return $this->hasMany('App\EaseSupport');
    }
    //------------------------------------------------------------
    //-----------------------------------------------------------
    public function ease_reviews() {
        return $this->hasMany('App\EaseReview','id','review_to');
    }
    //-----------------------------------------------------------
    public function ease_push_notifications() {
        return $this->hasMany('App\EasePushNotification','id','ease_user_id');
    }
    //-----------------------------------------------------------
    public function ease_uploaded_documents() {
        return $this->hasMany('App\EaseUploadedDocument','_id','ease_user_id');
    }
    //------------------------------------------------------------
    //-----------------------------------------------------------
    public function ease_providers() {
        return $this->hasMany('EaseProvider','_id','ease_user_id');
    }
    //------------------------------------------------------------
    //-----------------------------------------------------------
    public function ease_user_verifications() {
        return $this->hasMany('App\EaseUserVerification');
    }
    //-----------------------------------------------------------
    public function ease_wallet_histories() {
        return $this->hasMany('App\EaseWalletHistory','id','ease_user_id');
    }
    //------------------------------------------------------------

    public static function getSettings()
    {
        $settings = new stdClass();
        $settings->prefix = self::$prefix;
        $settings->table = self::$table_name;
        $settings->model = self::$model;
        $settings->view = self::$view;
        $settings->rows = self::$rows;
        $settings->enable = self::$enable;
        $settings->executor = self::$executor;
        return $settings;
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public static function findOrStore($input = NULL)
    {
        $model = self::$model;
        $settings = $model::getSettings();
        $model = $settings->model;
        if ($input == NULL) {
            $input = Input::all();
        }
        //remove empty array
        if (is_array($input)) {
            $input = array_filter($input);
        }
        if (!is_object($input)) {
            $input = (object)$input;
        }
        if (isset($input->_id) && !empty($input->_id)) {
            $item = $model::find($input->_id);
            if ($item) {
                $response['status'] = 'success';
                $response['data'] = $item;
                return $response;
            }
        }
        if (isset($input->slug) && !empty($input->slug)) {
            $item = $model::where('slug', '=', $input->slug)->first();
            if ($item) {
                $response['status'] = 'success';
                $response['data'] = $item;
                return $response;
            }
        }
        return $model::store($input);
    }

    //------------------------------------------------------------
    public static function store($input = NULL)
    {
        $model = self::$model;
        $settings = $model::getSettings();
        $model = $settings->model;
        if ($input == NULL) {
            $input = Input::all();
        }
        if (!is_object($input)) {
            $input = (object)$input;
        }
        //if _id is provided then find
        if (isset($input->_id) && !empty($input->_id)) {
            $validator = Validator::make((array)$input, $model::update_rules());
            if ($validator->fails()) {
                $response['status'] = 'failed';
                $response['errors'][] = $validator->messages()->all();
                return $response;
            }

            $item = $model::withTrashed()->where('_id', $input->_id)->first();
            if ($settings->executor == true && Auth::check()) {
                //$user_id = Auth::connection($connection1)->
                $item->modified_by = Auth::user()->id;
            }
        }
        if (isset($input->slug) && !empty($input->slug)) {
            $validator = Validator::make((array)$input, $model::update_rules());
            if ($validator->fails()) {
                $response['status'] = 'failed';
                $response['errors'][] = $validator->messages()->all();
                return $response;
            }
            $item = $model::withTrashed()->where('slug', '=', $input->slug)->first();
            if ($settings->executor == true && Auth::check()) {
                $item->modified_by = Auth::user()->id;
            }
        }
        if (!isset($item)) {
            $validator = Validator::make((array)$input, $model::create_rules());
            if ($validator->fails()) {
                $response['status'] = 'failed';
                $response['errors'][] = $validator->messages()->all();
                return $response;
            }
            $item = new $model();
            if ($settings->executor == true && Auth::check()) {
                $item->created_by = Auth::user()->id;
            }
        }
        //$columns = Schema::getColumnListing($settings->table);
        //--------------------------------------------------------
        //inserting the names of the columns in the columns array
        //--------------------------------------------------------
        $columns = [
            'user_id',
            'verified',
            'gender',
            'rating',
            'wallet',
            'nationality',
            'number_of_reviews',
            'national_iqama_id',
            'email_verification_code',
            'mobile_verification_code',
            'email_status',
            'created_by',
            'modified_by',
            'deleted_by',
            'created_at',
            'modified_at',
            'deleted_at',
    ];
        $input_array = (array)$input;
        foreach ($columns as $key) {
            if (array_key_exists($key, $input_array)) {
                if ($key == 'name') {
                    $item->$key = ucwords($input_array[$key]);
                } else {
                    $item->$key = $input_array[$key];
                }
            } else if (isset($input_array['name']) && $key == 'slug' && !array_key_exists($key, $input_array)) {
                $item->$key = Str::slug($input_array['name']);
            }
        }
        try {
            $item->save();
            $response['status'] = 'success';
            $response['data'] = $item;
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //------------------------------------------------------------
    public function createdBy()
    {
        return $this->belongsTo('User');
    }

    //------------------------------------------------------------
    public function modifiedBy()
    {
        return $this->belongsTo('User');
    }

    //------------------------------------------------------------
    public function deletedBy()
    {
        return $this->belongsTo('User');
    }

    //------------------------------------------------------------
    public static function deleteItem($id)
    {
        $model = self::$model;
        $item = $model::where('_id',$id)->first();
        if (self::$enable == true) {
            $item->enable = 0;
        }
        if (Auth::check()) {
            $item->deleted_by = Auth::user()->id;
        }
        $item->deleted_at = date("Y-m-d H:i:s");
        try {
            $item->save();
            $response['status'] = 'success';
            $response['data'] = $item;
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //------------------------------------------------------------
    public static function getTrash($user_specific = false, $user_id = NULL)
    {
        $model = self::$model;
        $list = $model::onlyTrashed();
        if ($user_specific == true && $user_id == NULL) {
            $connection="mysql";
            $user_id = Auth::connection($connection)->user()->id;
        }
        if ($user_specific == true) {
            $list->where('user_id', $user_id);
        }
        $result = $list->paginate(self::$rows);
        return $result;
    }

    //------------------------------------------------------------
    public static function getTrashCount($user_specific = false, $user_id = NULL)
    {
        $model = self::$model;
        $list = $model::onlyTrashed();
        if ($user_specific == true && $user_id == NULL) {
            $connection="mysql";
            $user_id = Auth::connection($connection)->user()->id;
        }
        if ($user_specific == true) {
            $list->where('user_id', $user_id);
        }
        $result = $list->count();
        return $result;
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
} //end of the class