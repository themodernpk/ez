<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class User extends Eloquent implements UserInterface, RemindableInterface
{
    protected $connection = 'mysql';
    /* ****** Code Completed till 10th april */
    use UserTrait, RemindableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'users';
    protected $guarded = array('id');
    protected $hidden = array('password');
    protected $fillable = [
        'username',
        'password',
        'email',
        'name',
        'mobile',
        'group_id',
        'active',
        'remember_token',
        'created_by',
        'modified_by',
        'deleted_by',
    ];
    //------------------------------------------------------------
    //------------------------------------------------------------
    public static function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'group_id' => 'required',
        ];
    }

    //------------------------------------------------------------
    public static function validate($input)
    {
        if (!empty($input['id'])) {
            $user = User::findorFail($input['id']);
            $rules = static::$rulesupdateUnique;
            if (isset($input['email']) && $input['email'] == $user->email) {
                $rules = static::$rulesupdate;
            }
        } else {
            $rules = static::$rulesadd;
        }
        return Validator::make($input, $rules);
    }

    //------------------------------------------------------------
    public static function authenticate($input = NULL)
    {
        if ($input == NULL) {
            $input = Input::all();
        }
        if (isset($input['email'])) {
            $credentials['email'] = $input['email'];
        }
        if (isset($input['password'])) {
            $credentials['password'] = $input['password'];
        }
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:4'
        );
        if (isset($input['apirequest']) && isset($input['apikey'])) {
            $existing_user = User::where('apikey', '=', $input['apikey'])->first();
            $response = array();
            if (!$existing_user) {
                $response['status'] = 'failed';
                $response['errors'][] = "Your Api Key Is Invalid";
                Auth::logout();
                return $response;
            } else {
                $get_user = User::find($existing_user->id);
            }
        } elseif (isset($input['apirequest']) && $input['apikey'] == "") {
            $response['status'] = 'failed';
            $response['errors'][] = "Api Key Is Required";
            Auth::logout();
            return $response;
        } else {
            $validate = Validator::make($input, $rules);
            if ($validate->fails()) {
                $response = array();
                $response['status'] = 'failed';
                $response['errors'] = $validate->errors();
                return $response;
            }
        }
        //if credentails are passed then attempt to login
        $remember = false;
        if (isset($input['remember']) && $input['remember'] == true && !isset($input['apirequest'])) {
            $remember = true;
        }
        if (isset($input['apirequest'])) {
            //check of for invalid credentials if it is apirquest
            if (!Auth::loginUsingId($get_user->id)) {
                $response = array();
                $response['status'] = 'failed';
                $response['errors'][] = "Api authentication failed, invalid credentials";
                return $response;
            }
        } else {
            //check of for invalid credentials
            if (!Auth::attempt($credentials, $remember)) {
                Activity::log($credentials['email'] . " - Login failure due to invalid credentials", NULL, "LOGIN", NULL);
                $response = array();
                $response['status'] = 'failed';
                $response['errors'][] = "Invalid Credentials";
                return $response;
            }
        }
        //if credentials are valid then process further
        $user_id = Auth::id();
        $user = User::find($user_id);
        //check user group is inactive
        if ($user->group->active == 0) {
            $response = array();
            $response['status'] = 'failed';
            $response['errors'][] = "Your account belongs to inactive user group.";
            Activity::log($credentials['email'] . " - Login failure, User group is inactive", NULL, "LOGIN", NULL, $user->id);
            Auth::logout();
            return $response;
        }
        //check user group is inactive
        if ($user->active == 0) {
            $response = array();
            $response['status'] = 'failed';
            $response['errors'][] = "Your account is inactive.";
            Activity::log($credentials['email'] . " - Login failure, User account is inactive", NULL, "LOGIN", NULL, $user->id);
            Auth::logout();
            return $response;
        }
        //check where user permission "disallow-login"
        if (!Permission::check('allow-login')) {
            $response = array();
            $response['status'] = 'failed';
            $response['errors'][] = "You don't have permission to login";
            Activity::log($credentials['email'] . " - Login failure, user does not have permission to login", NULL, "LOGIN", NULL, $user->id);
            Auth::logout();
            return $response;
        }
        //check where user permission "disallow-login"
        if (isset($input['apirequest']) && !Permission::check('api-access')) {
            $response = array();
            $response['status'] = 'failed';
            $response['errors'][] = "API Access denied";
            Activity::log($credentials['email'] . " - API access denied", NULL, "API", NULL, $user->id);
            Auth::logout();
            return $response;
        }
        //generate log if some login during off hours
        $hour = date('H');
        if ($user->group->slug != 'admin' && (($hour >= 0 && $hour < 10) || $hour > 22)) {
            Activity::log($user->name . " - Login during off hours at <b>" . Dates::dateformat(date('Y-m-d h:i:s')) . "</b>", $user->id, "LOGIN");
        }
        //update last login column
        $user->lastlogin = Dates::now();
        $user->save();
        if (Auth::viaRemember()) {
            return Redirect::route('dashboard')->with('flash_success', 'Remember login');
        }
        $response = array();
        $response['status'] = 'success';
        $response['data'] = $user;
        return $response;
    }

    //------------------------------------------------------------
    public function group()
    {
        return $this->belongsTo('Group');
    }

    //------------------------------------------------------------
    public static function getList($current_user_only = false)
    {
        $modelname = __CLASS__;
        $results = Custom::search($modelname, 'name', $current_user_only = false);
        return $results;
    }

    //------------------------------------------------------------
    public static function thumbnail($id = NULL, $size = 200)
    {
        if ($id == NULL) {
            $id = Auth::user()->id;
        }
        $email = User::find($id)->email;
        $thumb = md5($email);
        $thumb_url = "http://www.gravatar.com/avatar/" . $thumb . "?s=" . $size;
        return $thumb_url;
    }

    //------------------------------------------------------------
    public static function store($input = NULL, $send_password_via_email = false, $from_name = NULL, $from_email = NULL)
    {
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
        $original_input = $input;
        //if id is provided then find
        if (isset($input->id) && !empty($input->id)) {
            $item = User::withTrashed()->where('id', $input->id)->first();
            if (isset(Auth::user()->id)) {
                $item->modified_by = Auth::user()->id;
            }
        } else {
            if (!isset($input->username) || empty($input->username)) {
                $input->username = Common::generate_username($input->email);
            }
            if (!isset($input->password)) {
                $input->password = Common::generate_password();
            }
            $validator = Validator::make((array)$input, User::rules());
            if ($validator->fails()) {
                $response['status'] = 'failed';
                $response['errors'] = $validator->messages()->all();
                return $response;
            }
            $item = new User();
            if (isset(Auth::user()->id)) {
                $item->created_by = Auth::user()->id;
            }
        }
        $columns = Schema::getColumnListing('users');
        $input = (array)$input;
        foreach ($input as $key => $value) {
            if (in_array($key, $columns)) {
                if ($key == 'name') {
                    $item->$key = ucwords($value);
                } else if ($key == 'password') {
                    $item->$key = Hash::make($value);
                } else {
                    $item->$key = $value;
                }
            }
        }
        try {
            $item->save();
            $response['status'] = 'success';
            $response['data'] = $item;
            //Send email to the user
            if ($send_password_via_email == true) {
                $email_input = array();
                $email_input['email'] = $original_input->email;
                $email_input['password'] = $original_input->password;
                $email_input['name'] = $original_input->name;
                if ($from_email != NULL) {
                    $email_input['from_email'] = $from_email;
                }
                if ($from_name != NULL) {
                    $email_input['from_name'] = $from_name;
                }
                $email_response = User::sendCredentialsViaEmail($email_input);
            }
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }
    //------------------------------------------------------------
    /*
     * Following  parameters can be set in $input
     * email, password, from_name, from_email
     */
    public static function sendCredentialsViaEmail($input)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        );
        $validate = Validator::make($input, $rules);
        if ($validate->fails()) {
            $response = array();
            $response['status'] = 'failed';
            $response['errors'] = $validate->errors();
            return json_encode($response);
        }
        $subject = "[Credentials] " . Setting::value('app-name');
        if (isset($input['from_email'])) {
            $from_email = $input['from_email'];
        } else {
            if (isset(Auth::user()->email)) {
                $from_email = Auth::user()->email;
            } else {
                $from_email = "noreply@" . $_SERVER['SERVER_NAME'];
            }
        }
        if (isset($input['from_name'])) {
            $from_name = $input['from_name'];
        } else {
            if (isset(Auth::user()->name)) {
                $from_name = Auth::user()->name;
            } else {
                $from_name = Setting::value('app-name');
            }
        }
        $from = array($from_email => $from_name);
        $message = View::make('core::email-alerts.send-credentials')->with('data', $input)->render();
        $to[] = $input['email'];
        try {
            $response = CoreSmtp::send_email($from, $to, $subject, $message);
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //------------------------------------------------------------
    public static function register_by_email_only($input)
    {
        $rules = array(
            'email' => 'required|email|unique:users',
            'group_id' => 'required'
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $response['status'] = 'failed';
            $response['errors'] = $validator->messages()->all();
            return $response;
        }
        $email_d = explode("@", $input['email']);
        $input['name'] = $email_d[0];
        $input['username'] = Common::generate_username($input['email']);
        $input['password'] = Common::generate_password();
        $response = User::store($input);
        return $response;
    }

    //------------------------------------------------------------
    public static function dbCreateForgotPasswordColumn()
    {
        Schema::table('users', function ($table) {
            $table->string('forgot_password')->nullable()->after('remember_token');
        });
    }

    //------------------------------------------------------------
    public static function sendResetPasswordOTP($email)
    {
        $input = new stdClass();
        $rules = array(
            'email' => 'required|email',
        );
        $validate = Validator::make(array('email' => $email), $rules);
        if ($validate->fails()) {
            $response['status'] = 'failed';
            $response['errors'] = $validate->messages();
            return $response;
        }
        //find user based on email
        $user = User::where('email', '=', $email)->withTrashed()->first();
        if (!$user) {
            $response['status'] = 'failed';
            $response['errors'][] = "User does not exist";
            return $response;
        }
        $otp = Common::generate_password(5);
        $user->forgot_password = Crypt::encrypt($otp);
        try {
            $user->save();
            //activity log
            Activity::log($user->name . " / " . $user->email . " - generated OTP to reset password", NULL, "PASSWORD", NULL, $user->id);
            //send email alert
            $subject = $user->name . " - Reset your " . Setting::value('app-name') . " password";
            $from = array("noreply@webreinvent.com" => Setting::value('app-name'));
            $input->otp = $otp;
            $input->user = $user;
            $message = View::make('core::email-alerts.send-reset-password')->with('data', $input)->render();
            $to[] = $email;
            $response = CoreSmtp::send_email($from, $to, $subject, $message);
            $response['status'] = 'success';
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //------------------------------------------------------------
    public static function resetPassword($input = NULL)
    {
        if ($input == NULL) {
            $input = Input::all();
        }
        if (!is_array($input)) {
            $input = (array)$input;
        }
        $object = (object)$input;
        $messages = array(
            'forgot_password.required' => 'Enter one time password (OTP)',
            'password.required' => 'Enter new password',
            'password.min:4' => 'Minimum 4 characters required password',
            'email.required' => 'Enter your email',
        );
        $rules = array(
            'forgot_password' => 'required',
            'password' => 'required',
            'email' => 'required|email'
        );
        $validate = Validator::make($input, $rules, $messages);
        if ($validate->fails()) {
            $response['status'] = 'failed';
            $response['errors'] = $validate->messages();
            return $response;
        }
        //find user based on email
        $user = User::where('email', '=', $object->email)->withTrashed()->first();
        if (!$user) {
            $response['status'] = 'failed';
            $response['errors'][] = "User does not exist";
            return $response;
        }
        //check if otp is match with exist otp in database
        $db_otp = Crypt::decrypt($user->forgot_password);
        if ($db_otp != trim($object->forgot_password)) {
            $response['status'] = 'failed';
            $response['errors'][] = "Invalid OTP";
            return $response;
        }
        $user->password = Hash::make($object->password);
        $user->forgot_password = NULL;
        try {
            $user->save();
            Activity::log($user->name . " / " . $user->email . " - password successfully reset", NULL, "PASSWORD", NULL, $user->id);
            $response['status'] = 'success';
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //------------------------------------------------------------
    public static function findByEmail($email)
    {
        $user = User::withTrashed()->where('email', '=', $email)->first();
        return $user;
    }

    //------------------------------------------------------------
    public static function updateAccount($input = NULL)
    {
        if ($input == NULL) {
            $input = Input::all();
        }
        if (!is_array($input)) {
            $input = (array)$input;
        }
        $input = array_unique(array_filter($input));
        $object = (object)$input;
        $current_details = User::find(Auth::user()->id);
        //check if email is updated
        if (isset($object->email) && $current_details->email != $object->email) {
            $exist = User::where('email', '=', $object->email)->first();
            if ($exist) {
                $response['status'] = 'failed';
                $response['errors'][] = 'This email is associated with other account';
                return $response;
            }
        }
        $columns = Schema::getColumnListing('users');
        foreach ($input as $key => $value) {
            if (in_array($key, $columns)) {
                if ($key == 'name') {
                    $current_details->$key = ucwords($value);
                } else if ($key == 'password') {
                    $current_details->$key = Hash::make($value);
                } else {
                    $current_details->$key = $value;
                }
            }
        }
        try {
            $current_details->save();
            $response['status'] = 'success';
            $response['data'] = $current_details;
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
}
