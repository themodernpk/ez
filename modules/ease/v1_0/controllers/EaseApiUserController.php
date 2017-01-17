<?php

class EaseApiUserController extends BaseController
{
    public $data;
    public $settings;

    public function __construct()
    {
    }

    //--------------------------------------------------------------------------------------
    function postUpdateProfile() {
        $input = (object)Input::all();
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $response = EaseUser::store($input);
        echo json_encode($response);
        die();
    }
    //-------------------------------------------------------
    function getEaseUser($id,$field_name=NULL) {
        if($field_name!=NULL){
            $user = EaseUser::where('_id',$id)->where($field_name,$field_name)->get()->toJson();
        }else{
            $user = EaseUser::where('_id',$id)->get()->toJson();
        }
        return $user;
    }
    //-------------------------------------------------------
    function sendValidationCode() {
        $input = (object)Input::all();
        $email = $input->email;
        $count = User::where('email',$email)->count();
        if($count<=0){
            $response= [];
            $responce['status']='failed';
            $response['error']="email not found";
            return $response;
        }
        $user = User::where('email',$email)->get();
        //$user_id is the column field of User
        $user_id= $user[0]->id;
        //geting easeuser instance
        $ease_user = Easeuser::where('user_id',$user_id)->get();
        $ease_user_id= $ease_user[0]->_id;
        //updating easeuser with a verification code
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $digits = 4;
        $otpcode = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $easeUserInstance = [];
        $easeUserInstance['_id']=$ease_user_id;
        $easeUserInstance['email_verification_code']=$otpcode;
        $response = EaseUser::store($easeUserInstance);

        Mail::send('ease::email.passwordreset',array('key' => $otpcode),function($message)
        {
            $email = Input::get('email');
            $pass = Input::get('name');
            $message->to($email,$pass)->subject("welcome");
        });
        $response=[];
        $response['status']="success";
        return $response;

    }
    //-------------------------------------------------------
    function isUserVerified() {
        //ease_user_id will be provided
        $input = (Object)Input::all();
        $ease_user_id = $input->ease_user_id;

        $user = EaseUser::where('_id',$ease_user_id)->get();
        //$user_id is the column field of User
        $is_verified= $user[0]->verified;
        //checking if the user is verified

        if($is_verified){
            $response = [];
            $response['status']="verified";
            return $response;
        }
        $response = [];
        $response['status']="not verified";
        return $response;
    }
    //-------------------------------------------------------
    function hasUserVerified() {

    }
    //-------------------------------------------------------
    function postForgotPassword() {
        $input = (object)Input::all();
        $email = $input->email;
        $count = User::where('email',$email)->count();
        if($count<=0){
            $response= [];
            $responce['status']='failed';
            $response['error']="email not found";
            return $response;
        }
        $user = User::where('email',$email)->get();
        //$user_id is the column field of User
        $user_id= $user[0]->id;
        //geting easeuser instance
        $ease_user = Easeuser::where('user_id',$user_id)->get();
        $ease_user_id= $ease_user[0]->_id;
        //updating easeuser with a verification code
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $digits = 4;
        $otpcode = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $easeUserInstance = [];
        $easeUserInstance['_id']=$ease_user_id;
        $easeUserInstance['email_verification_code']=$otpcode;
        $response = EaseUser::store($easeUserInstance);

        Mail::send('ease::email.passwordreset',array('key' => $otpcode),function($message)
        {
            $email = Input::get('email');
            $pass = Input::get('name');
            $message->to($email,$pass)->subject("welcome");
        });
        $response=[];
        $response['status']="success";
        return $response;
    }
    //-------------------------------------------------------
    function checkCode() {
        $input = (Object)Input::all();
        $otpcode = $input->otpcode;
        $email = $input->email;

        $user= User::where('email',$email)->get();
        $user_id = $user[0]->id;

        $ease_user = EaseUser::where('user_id',$user_id)->get();
        $email_verification_code = $ease_user[0]->email_verification_code;
        //checking code
        if($email_verification_code==$otpcode) {
            $verificationInstance = [];
            $verificationInstance['ease_user_id']=$ease_user[0]->_id;
            $verificationInstance['email']="true";
            $res = EaseUserVerification::store($verificationInstance);
            $response = [];
            $response['status']="success";
            return $response;
        }
        $response = [];
        $response['status']="failed";
        return $response;
    }
    //-------------------------------------------------------
    function resendCode() {
        $input = (object)Input::all();
        $email = $input->email;
        $count = User::where('email',$email)->count();
        if($count<=0){
            $response= [];
            $responce['status']='failed';
            $response['error']="email not found";
            return $response;
        }
        $user = User::where('email',$email)->get();
        //$user_id is the column field of User
        $user_id= $user[0]->id;
        //geting easeuser instance
        $ease_user = Easeuser::where('user_id',$user_id)->get();
        $ease_user_id= $ease_user[0]->_id;
        //updating easeuser with a verification code
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $digits = 4;
        $otpcode = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $easeUserInstance = [];
        $easeUserInstance['_id']=$ease_user_id;
        $easeUserInstance['email_verification_code']=$otpcode;
        $response = EaseUser::store($easeUserInstance);

        Mail::send('ease::email.test',array('key' => $otpcode),function($message)
        {
            $email = Input::get('email');
            $pass = Input::get('name');
            $message->to($email,$pass)->subject("welcome");
        });
        $response=[];
        $response['status']="success";
        return $response;
    }
    //-------------------------------------------------------
    function postResetPassword() {
        $input = (Object)Input::all();
        $email = $input->email;
        $password = $input->password;

        $userInstance=[];
        $userInstance['email']=$email;
        $userInstance['password']=$password;

        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $res = User::store($userInstance);

        $response = [];
        $response['status']="success";
        return $response;
    }
    //-------------------------------------------------------
    function postChangePassword() {
        $input = (object)Input::all();
        $pass = $input->password;
        $newPassword = $input->newpassword;
        $tempPass = Hash::make($pass);
        $apikey = $input->apikey;
        $user = User::where('apikey',$apikey)->first();
        $id = $user->id;
        $userPassword = $user->password;
        if (!(Hash::check($pass, $userPassword)))
        {
            $response = [];
            $response['status']='failed';
            $response['data']='password is not correct';
            return $response;
        }

        $userInstance = [];
        $userInstance['password']=$newPassword;
        $userInstance['id']=$id;

        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $response = User::store($userInstance);
        $response = [];
        $response['status']="success";
        $response['data']="changed successfully";
        return $response;
    }
    //-------------------------------------------------------
    function postWriteReviewProvider() {

        $input = (object)Input::all();
        $review_to = $input->review_to;
        $rating = $input->rating;
        $ease_Provider = EaseProvider::where('_id',$review_to)->get();
        $ease_user_id = $ease_Provider[0]->ease_user_id;
        $ease_user = EaseUser::where('_id',$ease_user_id)->get();
        $user_rating = $ease_user[0]->rating;
        $number_of_reviews = $ease_user[0]->number_of_reviews;
        $new_number_of_reviews=$number_of_reviews + 1;
        $new_rating = ($rating+$user_rating)/$new_number_of_reviews;

        $easeUserInstance=[];
        $easeUserInstance['rating']=$new_rating;
        $easeUserInstance['number_of_reviews']=$new_number_of_reviews;
        $easeUserInstance['_id']=$ease_user[0]->_id;
        $res = Easeuser::store($easeUserInstance);

        $easeReviewInstance=[];
        $easeReviewInstance['rating']=$new_rating;
        $easeReviewInstance['review_to']=$review_to;
        $easeReviewInstance['review_by']=$input->review_by;
        $easeReviewInstance['comment']=$input->comment;
        $timestamp = new Date();
        $easeReviewInstance['comment_on']=$timestamp;
        $easeReviewInstance['ease_service_request_id']=$input->ease_service_request_id;

        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $response = EaseReview::store($input);
        echo json_encode($response);
        die();
    }
    //-------------------------------------------------------
    function postWriteReviewSeeker() {

        $input = (object)Input::all();
        $review_to = $input->review_to;
        $rating = $input->rating;
        $ease_Provider = EaseSeeker::where('_id',$review_to)->get();
        $ease_user_id = $ease_Provider[0]->ease_user_id;
        $ease_user = EaseUser::where('_id',$ease_user_id)->get();
        $user_rating = $ease_user[0]->rating;
        $number_of_reviews = $ease_user[0]->number_of_reviews;
        $new_number_of_reviews=$number_of_reviews + 1;
        $new_rating = ($rating+$user_rating)/$new_number_of_reviews;

        $easeUserInstance=[];
        $easeUserInstance['rating']=$new_rating;
        $easeUserInstance['number_of_reviews']=$new_number_of_reviews;
        $easeUserInstance['_id']=$ease_user[0]->_id;
        $res = Easeuser::store($easeUserInstance);

        $easeReviewInstance=[];
        $easeReviewInstance['rating']=$new_rating;
        $easeReviewInstance['review_to']=$review_to;
        $easeReviewInstance['review_by']=$input->review_by;
        $easeReviewInstance['comment']=$input->comment;
        $timestamp = new Date();
        $easeReviewInstance['comment_on']=$timestamp;
        $easeReviewInstance['ease_service_request_id']=$input->ease_service_request_id;
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $response = EaseReview::store($input);
        echo json_encode($response);
        die();
    }
    //-------------------------------------------------------
    function postWriteReport() {

        $input = (object)Input::all();
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $response = EaseReportIssue::store($input);
        echo json_encode($response);
        die();
    }
    //-------------------------------------------------------
    function postWriteToSupport() {
        $input = (object)Input::all();
        $apikey = $input->apikey;
        if($input->type == "seeker"){

            $res = User::where('apikey',$apikey)->get();
            $ease = EaseUser::where('user_id',$res[0]->id)->get();
            $seeker= EaseSeeker::where('ease_user_id',$ease[0]->_id)->get();
            $input->ease_user_id = $seeker[0]->_id;

        }else{
            $res = User::where('apikey',$apikey)->get();
            $ease = EaseUser::where('user_id',$res[0]->id)->get();
            $seeker= EaseProvider::where('ease_user_id',$ease[0]->_id)->get();
            $input->ease_user_id = $seeker[0]->_id;
        }
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });

        $response = EaseSupport::store($input);
        if($response['status'] == 'success'){
            $response=[];
            $response['status']="success";
            return $response;
        }
        return $response;
    }
    //-------------------------------------------------------
    function getPaymentHistory() {
    }
    //-------------------------------------------------------
    function postAddMoneyToWallet($id) {
    }
    //-------------------------------------------------------
    function getLogout() {
        Auth::logout();
    }
    //-------------------------------------------------------
    function index()
    {
        $model = $this->data->model;
        if (isset($this->data->input->show) && $this->data->input->show == 'trash') {
            $this->data->list = $model::getTrash();
        } else {
            if (isset($this->data->input->q) && !empty($this->data->input->q)) {
                $this->data->list = $this->search();
            } else {
                $list = $model::orderBy("created_at", "ASC");
                $this->data->list = $list->paginate($this->data->rows);
            }
        }
        $this->data->trash_count = $model::getTrashCount();
        return View::make($this->data->view . 'index')->with('title', 'Item List')->with('data', $this->data);
    }

    //------------------------------------------------------
    function search()
    {
        $model = $this->data->model;
        $list = $model::orderBy("created_at", "ASC");
        $term = $this->data->input->q;
        $list->where('name', 'LIKE', '%' . $term . '%');
        $list->orWhere('slug', 'LIKE', '%' . $term . '%');
        $list->orWhere('id', '=', $term);
        $result = $list->paginate($this->data->rows);
        return $result;
    }

    //------------------------------------------------------
    function create()
    {
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                $error_message = "You don't have permission create";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $model = $this->data->model;
        $response = $model::store();
        echo json_encode($response);
        die();
    }

    //------------------------------------------------------
    function read($id)
    {
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-read')) {
                $error_message = "You don't have permission read";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $model = $this->data->model;
        $item = $model::withTrashed()->where('id', $id)->first();
        if ($item) {
            $item->createdBy;
            $item->modifiedBy;
            $item->deletedBy;
            $response['status'] = 'success';
            $response['data'] = $item;
        } else {
            $response['status'] = 'success';
            $response['errors'][] = 'Not found';
        }
        if ($this->data->input->format == 'json') {
            $response_in_json = json_encode($item);
            $response['html'] = View::make($this->data->view . 'elements.view-item')
                ->with('data', json_decode($response_in_json))
                ->render();
            echo json_encode($response);
            die();
        } else {
            return $response;
        }
    }

    //------------------------------------------------------
    function update()
    {
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-update')) {
                $error_message = "You don't have permission update";
                if (isset($this->data->input->format) && $this->data->input->format == "json") {
                    $response['status'] = 'failed';
                    $response['errors'][] = $error_message;
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::route('error')->with('flash_error', $error_message);
                }
            }
        });
        $model = $this->data->model;
        $response = $model::store();
        echo json_encode($response);
        die();
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function enable()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $input['id'] = $this->data->input->pk;
            $input['enable'] = 1;
            $response = $model::store($input);
            echo json_encode($response);
            die();
        } else if (is_array($this->data->input->id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $input['id'] = $id;
                $input['enable'] = 1;
                $model::store($input);
            }
        }
    }

    //------------------------------------------------------
    function disable()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $input['id'] = $this->data->input->pk;
            $input['enable'] = 0;
            $response = $model::store($input);
            echo json_encode($response);
            die();
        } else if (is_array($this->data->input->id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $input['id'] = $id;
                $input['enable'] = 0;
                $model::store($input);
            }
        }
    }

    //------------------------------------------------------
    function delete()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $response = $model::deleteItem($this->data->input->pk);
            echo json_encode($response);
            die();
        } else if (is_array($this->data->input->id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $model::deleteItem($id);
            }
        }
    }

    //------------------------------------------------------
    function bulkAction()
    {
        $model = $this->data->model;
        if ($this->data->input->action == 'search') {
            $input = Input::all();
            unset($input['_token']);
            return Redirect::route($this->data->prefix . "-index", $input);
        }
        if (!Permission::check($this->data->prefix . '-update')) {
            $response['status'] = 'failed';
            $response['errors'][] = constant('core_msg_permission_denied');
        }
        if (!isset($this->data->input->pk) && !isset($this->data->input->id)) {
            $response['status'] = 'failed';
            $response['errors'][] = constant('core_no_item_selected');
        }
        if (isset($response['status'])
            && $response['status'] == 'failed'
            && isset($this->data->input->format)
            && $this->data->input->format == 'json'
        ) {
            echo json_encode($response);
            die();
        } else if (isset($response['status']) && $response['status'] == 'failed') {
            return Redirect::back()->with('flash_error', $response['errors'][0]);
        }
        switch ($this->data->input->action) {
            case 'enable':
                $this->enable();
                if (isset($this->data->input->format) && $this->data->input->format == 'json') {
                    $response['status'] = 'success';
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::back()->with('flash_success', constant('core_success'));
                }
                break;
            //------------------------------
            case 'disable':
                $this->disable();
                if (isset($this->data->input->format) && $this->data->input->format == 'json') {
                    $response['status'] = 'success';
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::back()->with('flash_success', constant('core_success'));
                }
                break;
            //------------------------------
            case 'delete':
                $this->delete();
                if (isset($this->data->input->format) && $this->data->input->format == 'json') {
                    $response['status'] = 'success';
                    echo json_encode($response);
                    die();
                } else {
                    return Redirect::back()->with('flash_success', constant('core_success'));
                }
                break;
            //------------------------------
            case 'restore':
                foreach ($this->data->input->id as $id) {
                    $model::withTrashed()->where('id', $id)->restore();
                }
                return Redirect::back()->with('flash_success', constant('core_msg_permission_denied'));
                break;
            //------------------------------
            case 'permanent_delete':
                foreach ($this->data->input->id as $id) {
                    $model::withTrashed()->where('id', $id)->forceDelete();
                }
                return Redirect::back()->with('flash_success', constant('core_success_message'));
                break;
            //------------------------------
        }
    }
    //------------------------------------------------------
    //------------------------------------------------------
} // end of the class