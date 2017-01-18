<?php
//use Illuminate\Database\Eloquent\SoftDeletingTrait;
//using jenssengers orm and SoftDeletingTrait
use Jenssegers\Mongodb\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class EaseProvider extends Eloquent
{
    protected $connection = 'mongodb';
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'ease_user_id',
        'ease_service_id',
        'pending_commission',
        'amount_withdrew',
        'commission_paid_to_company',
        "profession_level",
        'is_available',
        'slug',

        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'modified_at',
        'deleted_at',
    ];

    public static $prefix = 'ease-provider';
    public static $table_name = 'ease_providers';
    public static $model = 'EaseProvider';
    public static $view = 'ease::provider.';
    public static $rows = 25;
    public static $enable = false;
    public static $executor = true;

    /**
     * EaseProvider constructor.
     * @param string $connection
     */
    /*public function __construct($connection)
    {

        $n=DB::table('ease_providers')->orderBy('id', 'desc')->first();
        if(empty($n->id)){
            $n=0;
            $this->setRowNumber($n->id);
            $this->primaryKey = $this->rowNumber+1;
        }else{
            $this->setRowNumber($n->id);
            $this->primaryKey = $this->rowNumber+1;
        }
    }*/
    //------------------------------------------------------------
    /**
     * @param mixed $rowNumber
     */
    public function setRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;
    }
    //------------------------------------------------------------
    public static function create_rules()
    {
        return [
            'ease_user_id' => 'required',
        ];
    }
    public function ease_provider_service(){
        return $this->embedsMany('EaseProviderService','_id','ease_provider_id');
    }
    //------------------------------------------------------------
    public function ease_provider_service_requests() {
        return $this->hasMany('EaseProviderServiceRequest');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function ease_service_requests() {
        return $this->hasMany('EaseServiceRequest','_id','profession_level_id');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function ease_service() {
        return $this->belongsTo('EaseService');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function ease_report_issues() {
        return $this->embedsMany('EaseReportIssue','_id','ease_provider_id');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function ease_payments() {
        return $this->belongsTo('EasePayment','payment_to','_id');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function ease_user() {
        return $this->belongsTo('EaseUser','ease_user_id','_id');
    }
    public function user() {
        return $this->belongsTo('User');
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public static function update_rules()
    {
        return [
            '_id' => 'required',
        ];
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
        //--------------------------------------------------------
        //inserting the names of the columns in the columns array
        //--------------------------------------------------------
        $columns = [
            'ease_user_id',
            'ease_service_id',
            'pending_commission',
            'amount_withdrew',
            'commission_paid_to_company',
            "profession_level",
            'is_available',
            'slug',

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