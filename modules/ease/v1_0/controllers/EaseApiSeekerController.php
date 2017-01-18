<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
//require "public/document_pictures";
//require "public/profile";

class EaseApiSeekerController extends BaseController
{
    public $data;
    public $settings;

    public function __construct()
    {

    }
    //------------------------------------------------------
    function postRegister() {
        $input = (object)Input::all();
        //---------
        //storing the record in user table
        $userInstance = [];
        $userInstance['email'] = $input->email;
        $userInstance['password'] = $input->password;
        $userInstance['name'] = $input->name;
        $userInstance['mobile'] = $input->mobile;
        $userInstance['apikey']=md5(uniqid(rand(), true));
        $userInstance['group_id']=3;

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
        $user = User::store($userInstance);
        if($user['status']=='success'){
            $userId= $user['data']->id;
        }
        if(!isset($userId)){
            $response['status']="failed";
            $response['error']="email is in use";
            return $response;
        }
        //-----------
        //storing a record in user
        $digits = 4;
        $otpcode = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $easeUserInstance = [];
        $easeUserInstance['user_id'] = $userId;
        $easeUserInstance['national_iqama_id'] = $input->national_iqama_id;
        $easeUserInstance['verified']="false";
        $easeUserInstance['email_verification_code']=$otpcode;
        $easeUserInstance['email_status']="false";
        if(isset($input->gender)){
            $easeUserInstance['gender']=$input->gender;
        }
        $easeUserInstance['rating']=0;
        $easeUserInstance['number_of_reviews']=0;
        $easeUserInstance['wallet']=0;

        $easeUser = EaseUser::store($easeUserInstance);
        if($easeUser['status']=='success'){
            $easeUserId= $easeUser['data']->id;
        }
        //storing a particular record in ease_user_verification
        $easeUserVerificationInstance = [];
        $easeUserVerificationInstance['ease_user_id'] = $easeUserId;
        $easeUserVerificationInstance['mobile']="false";
        $easeUserVerificationInstance['email']="false";
        $easeUserVerificationInstance['iqama']="false";
        $easeUserVerificationInstance['documents']="pending";
        $response = EaseUserVerification::store($easeUserVerificationInstance);
        //---------
        $easeSeekerInstance = [];
        $easeSeekerInstance['ease_user_id']=$easeUserId;
        $easeSeekerInstance['cancelletion_amount']=0;
        $response = EaseSeeker::store($easeSeekerInstance);
        $seeker_data = $response['data']->_id;
        //------------
        if(Input::has('profile')){
            $documentt = $input->profile;
            $document="data:image/jpeg;base64,".$documentt;
            $user = User::where('email',$input->email)->first();
            $userid = $user->id;
            $username = $user->name;
            $profile=$userid."_".$username.".jpeg";
            $filePath = "http://103.196.221.22/php/ease/public/profile/".$profile;
            $path = public_path();
            $output_file=$path.'/public/profile/'.$profile;
            function base64ToImag($document, $output_file) {
                $file = fopen($output_file, "wb");
                $data = explode(',', $document);
                fwrite($file, base64_decode($data[1]));
                fclose($file);
                return $output_file;
            }
            base64ToImag($document,$output_file);
            $easeUploadedDocumentInstance = [];
            $easeUploadedDocumentInstance['ease_user_id']=$seeker_data;
            $easeUploadedDocumentInstance['document_type']='profile';
            $easeUploadedDocumentInstance['document_name']=$profile;
            $easeUploadedDocumentInstance['url']=$filePath;
            $res = EaseUploadedDocument::store($easeUploadedDocumentInstance);
        }
        if(Input::has('document_name')){
            $documentt = $input->document_name;
            $document="data:image/jpeg;base64,".$documentt;
            $user = User::where('email',$input->email)->first();
            $userid = $user->id;
            $username = $user->name;
            $document_name=$userid."_".$username.".jpeg";
            $filePath = "http://103.196.221.22/php/ease/public/document_pictures/".$document_name;
            $path = public_path();
            $output_file=$path.'/public/document_pictures/'.$document_name;
            //code to convert base 64 image
            function base64ToImage($document, $output_file) {
                $file = fopen($output_file, "wb");
                $data = explode(',', $document);
                fwrite($file, base64_decode($data[1]));
                fclose($file);
                return $output_file;
            }
            base64ToImage($document,$output_file);
            $easeUploadedDocumentInstance = [];
            $easeUploadedDocumentInstance['ease_user_id']=$seeker_data;
            $easeUploadedDocumentInstance['document_type']='national_id';
            $easeUploadedDocumentInstance['document_name']=$document_name;
            $easeUploadedDocumentInstance['url']=$filePath;
            $res = EaseUploadedDocument::store($easeUploadedDocumentInstance);
        }
        Mail::send('ease::email.test',array('key' => $otpcode),function($message)
        {
            $email = Input::get('email');
            $pass = Input::get('name');
            $message->to($email,$pass)->subject('Welcome!');
        });
        //---------
        $response['data']->apikey=$userInstance['apikey'];
        return $response;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getSeeker() {
        $input = (Object)Input::all();
        if(Input::has('field_name')){
            $input = (Object)Input::all();
            $apikey = Input::get('apikey');
            $user = User::where('apikey',$apikey)->first();
            $ease_user = EaseUser::where('user_id',$user->id)->get();
            $id = EaseSeeker::where('ease_user_id',$ease_user[0]->_id)->first();
            if($input->field_name=='cancelletion_amount'||$input->field_name=="ease_user_id"){
                $field_name = Input::get('field_name');
                $seeker = EaseSeeker::where('_id',$id)->where($field_name,$field_name)->get()->toJson();
            }
            else{
                $field_name = Input::get('field_name');
                $seeker = EaseUser::where('_id',$id)->where($field_name,$field_name)->get()->toJson();
            }
        }
        else{
            $seeker=[];
            $apikey = Input::get('apikey');

            $user = User::where('apikey',$apikey)->get();

            $seeker['email']=$user[0]->email;
            $seeker['password']=$user[0]->password;
            $seeker['mobile']=$user[0]->mobile;
            $seeker['apikey']=$user[0]->apikey;
            $seeker['name']=$user[0]->name;

            $ease_user = EaseUser::where('user_id',$user[0]->id)->get();

            $seeker['verified']=$ease_user[0]->verified;
            $seeker['gender']=$ease_user[0]->gender;
            $seeker['rating']=$ease_user[0]->rating;
            $seeker['wallet']=$ease_user[0]->wallet;
            $seeker['national_iqama_id']=$ease_user[0]->national_iqama_id;

            $ease_seeker = EaseSeeker::where('ease_user_id',$ease_user[0]->_id)->get();

            $seeker['cancellation_amount']=$ease_seeker[0]->cancelletion_amount;
            $Seeker = EaseSeeker::where('ease_user_id',$ease_user[0]->_id)->first();
            $uploadedData = EaseUploadedDocument::where('ease_user_id',$Seeker->_id)->where('document_type','profile')->first();
            if(isset($uploadedData)){
                $seeker['profile']=$uploadedData->url;
            }
            $uploadeData = EaseUploadedDocument::where('ease_user_id',$Seeker->_id)->where('document_type','national_id')->first();
            if(isset($uploadeData)){
                $seeker['national_id']=$uploadeData->url;
            }

            return json_encode($seeker);
        }

        return $seeker;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postUpdateSeeker() {
        $input = (Object)Input::all();
        $apikey = Input::get('apikey');
        $user = User::where('apikey',$apikey)->get();
        $usersEmail = $user[0]->email;
        $ease_user = EaseUser::where('user_id',$user[0]->id)->get();
        $seekerId = EaseSeeker::where('ease_user_id',$ease_user[0]->_id)->get();
        $easeSeekerInstance= [];
        $easeSeekerInstance['_id']=$seekerId[0]->_id;
        if(Input::has('cancelletion_amount')){
            $easeSeekerInstance['cancelletion_amount']=$input->cancelletion_amount;
        }
        //---------------------------------------------------------------------------------------
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
        $seeker = EaseSeeker::store($easeSeekerInstance);
        //getting EaseSeeker instance
        $easeUserId= EaseSeeker::where('_id',$seekerId[0]->_id)->get();
        //$ease_user_id is the column field of EaseSeeker
        $ease_user_id= $easeUserId[0]->ease_user_id;
        $user=EaseUser::where('_id',$ease_user_id)->get();
        //$user_id is the user_id column of user
        $user_id=$user[0]->user_id;
        $easeUserInstance = [];
        $easeUserInstance['_id']=$ease_user_id;
        if(Input::has('gender')){
            $easeUserInstance['gender']=$input->gender;
        }
        EaseUser::store($easeUserInstance);
        //below is the user instance
        $user = User::where('id',$user_id)->get();
        $userid=$user[0]->id;
        $username=$user[0]->name;
        $easeUserName=$username;
        $AUserInstance['email']=$usersEmail;
        $user = User::where('email',$AUserInstance['email'])->first();
        $AUserInstance = [];
        if(Input::has('name')){
            //$AUserInstance['name']=$input->name;
            $user->name=$input->name;
        }
        if(Input::has('mobile')){
            //$AUserInstance['mobile']=$input->mobile;
            $user->mobile=$input->mobile;
        }
        $user->save();
        if(Input::has('profile')){
            $documentt = $input->profile;
            $document="data:image/jpeg;base64,".$documentt;
            $user = User::where('email',$usersEmail)->first();
            $userid = $user->id;
            $username = $user->name;
            $profile=$userid."_".$username.".jpeg";
            $filePath = "http://103.196.221.22/php/ease/public/profile/".$profile;
            $tempdocument = EaseUploadedDocument::where('document_type','profile')->where('ease_user_id',$seekerId[0]->id)->delete();

            $path = public_path();
            $output_file=$path.'/public/profile/'.$profile;
            function base64ToImag($document, $output_file) {
                $file = fopen($output_file, "wb");
                $data = explode(',', $document);
                fwrite($file, base64_decode($data[1]));
                fclose($file);
                return $output_file;
            }
            base64ToImag($document,$output_file);
            $easeUploadedDocumentInstance = [];
            $easeUploadedDocumentInstance['ease_user_id']=$seekerId[0]->_id;
            $easeUploadedDocumentInstance['document_type']='profile';
            $easeUploadedDocumentInstance['profile']=$profile;
            $easeUploadedDocumentInstance['url']=$filePath;
            $res = EaseUploadedDocument::store($easeUploadedDocumentInstance);
        }

        $response=[];
        $response['status']='success';
        return $response;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postRaiseServiceRequest() {
        $input=(Object)Input::all();
        $apikey = $input->apikey;
        $user = User::where('apikey',$apikey)->first();
        $easeUser = EaseUser::where('user_id',$user->id)->first();
        $easeSeeker = EaseSeeker::where('ease_user_id',$easeUser->_id)->first();
        $serviceRequest = [];
        $serviceRequest['ease_seeker_id']=$easeSeeker->_id;
        $serviceRequest['ease_service_id']=$input->ease_service_id;
        $serviceRequest['profession_level']=$input->profession_level;
        $serviceRequest['number_of_provider']=$input->number_of_provider;
        $serviceRequest['start_time']=$input->start_time;
        $serviceRequest['duration']=$input->duration;
        $serviceRequest['ease_country_id']=$input->ease_country_id;
        if(isset($input->lat)){
            $serviceRequest['lat']=$input->lat;
        }
        if(isset($input->lng)){
            $serviceRequest['lng']=$input->lng;
        }
        $serviceRequest['price']=$input->price;
        $serviceRequest['status']="not_started";
        $serviceRequest['scheduled']="false";
        $serviceRequest['city']=$input->city;
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
        $response = EaseServiceRequest::store($serviceRequest);
        echo json_encode($response);
        die();
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postUseCoupon($id) {
        $input=(object)Input::all();
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
        $coupon_code=$input->coupon_code;
        $coupon=EaseCoupon::where('coupon_code',$coupon_code)->get();
        $isCouponUsed = EaseUsedCoupon::where('ease_seeker_id',$input->ease_seeker_id)->count();
        if($isCouponUsed<=0)
        {
            $userCoupon = new EaseUsedCoupon();
            $userCoupon->ease_coupon_id=$coupon->id;
            $userCoupon->ease_seeker_id=$id;
            $discount = EaseUsedCoupon::store($userCoupon);
            $response = $coupon->discounts->value;
            return $response;
        }
        $error_message="coupon has been used";
        return $error_message;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postCancelServiceRequest($id) {

        $input = (object)Input::all();
        $ease_seeker_id = $input->ease_seeker_id;
        $easeSeekerInstance =EaseSeeker::where('_id',$ease_seeker_id)->get();
        $pendingAmount = $easeSeekerInstance->cancelletion_amount;
        $easeSeekerInstance->cancelletion_amount = 15 + $pendingAmount;

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
        //adding cancelletion amount
        EaseSeeker::store($easeSeekerInstance);
        //updating the service request id
        $serviceRequestId = new EaseServiceRequest();
        $timestamp= Dates::now();
        $serviceRequestId->changed_at=$timestamp;
        $serviceRequestId->status="cancelled";
        $response = EaseServiceRequest::store($serviceRequestId);
        echo json_encode($response);
        die();
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postChargeCancelletionFee() {
        $input=Input::all();

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
        $cancelletionFees= new EaseSeeker();
        $cancelletionFees->_id=$input->ease_seeker_id;
        //or get the cancelletion charge from the admin
        $cancelletionFees->amount = 15;
        $cancelletionFees->status="success";
        //need to implement this related to payment
        $response = EaseSeeker::store($cancelletionFees);
        echo json_encode($response);
        die();

    }
    //------------------------------------------------------
    //------------------------------------------------------
    function postExtendTime() {
        $input = (object)Input::all();
        $input->status="going_on";
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
        $time = $input->time_extended;
        $expiresAt = Carbon::now()->addHours(10);
        $service_request = $input->ease_service_request_id;
        $timeLog = EaseServiceTimeLog::where('ease_service_request_id',$service_request)->get();
        //add some time in the end_time in the EaseServiceTimeLog
        $time = $input->time_extended;
        $date = new DateTime();
        $date->add(new DateInterval('P20D')); //use PT20H for 20 hours
        $response = EaseServiceTimeLog::store($input);
        echo json_encode($response);
        die();
    }
//------------------------------------------------------------------------------------------------
    function postMakePayment() {
        $input = (object)Input::all();
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
        //need to implement this
        $response = EaseServicePayment::store($input);
        echo json_encode($response);
        die();
    }
    //------------------------------------------------------
    function postUpdateServiceRequest() {
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
        $response = EaseServiceRequest::store();
        echo json_encode($response);
        die();
    }
    //-----------------------------------------------------------
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
            $response['html'] = View::make($this->data->view . 'service.view-item')
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