<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EaseApiProviderController extends BaseController

{
    public $data;
    public $settings;

    public function __construct()
    {

    }

    //-------------------------------------------------------
    function postRegister() {
        $input = (object)Input::all();
        //---------
        //storing the record in user table
        $userInstance = [];
        $userInstance['email'] = $input->email;
        $useremailaddress=$input->email;
        $userInstance['password'] = $input->password;
        $userInstance['name']= $input->name;
        $usernameaddress=$input->name;
        $userInstance['mobile'] = $input->mobile;
        $userInstance['group_id']=2;
        $userInstance['apikey']=md5(uniqid(rand(), true));

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
        $easeUserInstance['nationality'] = $input->nationality;
        if(isset($input->gender)){
            $easeUserInstance['gender'] = $input->gender;
        }
        $easeUserInstance['verified']=false;
        $easeUserInstance['email_verification_code']=$otpcode;
        $easeUserInstance['rating']=0;
        $easeUserInstance['wallet']=0;
        $easeUserInstance['number_of_reviews']=0;
        $easeUserInstance['email_status']="false";

        $easeUser = EaseUser::store($easeUserInstance);

        if($easeUser['status']=='success'){
            $easeUserId= $easeUser['data']->id;
        }
        //---------
        //storing a particular record in ease_user_verification
        $easeUserVerificationInstance = [];
        $easeUserVerificationInstance['ease_user_id'] = $easeUserId;
        $easeUserVerificationInstance['mobile']=false;
        $easeUserVerificationInstance['email']=false;
        $easeUserVerificationInstance['iqama']="false";
        $easeUserVerificationInstance['documents']="pending";

        $responseOne = EaseUserVerification::store($easeUserVerificationInstance);
        //------------

        $easeProviderInstance = [];
        $easeProviderInstance['ease_user_id']=$easeUserId;
        $easeProviderInstance['pending_commission']=0;
        $easeProviderInstance['amount_withdrew']=0;
        $easeProviderInstance['commission_paid_to_company']=0;
        $easeProviderInstance['is_available']=false;

        $response = EaseProvider::store($easeProviderInstance);
        if($response['status']="success"){
            $ease_user_id=$response['data']->ease_user_id;
            $ease_provider_id_new = $response['data']->_id;
        }
        $ser = $input->ease_service_id;
        $services = (explode("_",$ser));
        //$ease_user_id is the column field of EaseProvider
        //$ease_user_id= $response[0]->ease_user_id;
        $user=EaseUser::where('_id',$ease_user_id)->get();

        foreach($services as $service){
            $instance=[];
            $instance['ease_provider_id']=$ease_provider_id_new;
            $instance['ease_service_id']=$service;
            EaseProviderService::store($instance);
        }

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
            $easeUploadedDocumentInstance['ease_user_id']=$ease_provider_id_new;
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
            $easeUploadedDocumentInstance['ease_user_id']=$ease_provider_id_new;
            $easeUploadedDocumentInstance['document_type']='national_id';
            $easeUploadedDocumentInstance['document_name']=$document_name;
            $easeUploadedDocumentInstance['url']=$filePath;
            $res = EaseUploadedDocument::store($easeUploadedDocumentInstance);
        }

        $response['data']->apikey=$userInstance['apikey'];

        Mail::send('ease::email.test',array('key' => $otpcode),function($message)
        {
            $email = Input::get('email');
            $pass = Input::get('name');
            $message->to($email,$pass)->subject("welcome");
        });
        echo json_encode($response);
        die();
    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postProvider() {

        $input = (Object)Input::all();
        if(!isset($input->id)){
            $apikey = Input::get('apikey');
            $user = User::where('apikey',$apikey)->first();
            $ease_user = EaseUser::where('user_id',$user->id)->get();
            $id = EaseProvider::where('ease_user_id',$ease_user[0]->_id)->first();
        }else{
            $id=$input->id;
        }
        $input = (Object)Input::all();
        $ease_provider_id = $id->_id;
        $easeUserId= EaseProvider::where('_id',$ease_provider_id)->get();
        //$ease_user_id is the column field of EaseProvider
        $ease_user_id= $easeUserId[0]->ease_user_id;
        $user=EaseUser::where('_id',$ease_user_id)->get();
        //$user_id is the user_id column of user
        $user_id=$user[0]->_id;

        if(Input::has('field_name')){
            $columns=[
                'amount_withdrew',
                'ease_user_id',
                'ease_service_id',
                'pending_commission',
                'amount_withdrew',
                'commission_paid_to_company',
                'is_available'];

            foreach ($columns as $column) {
                if ($input->field_name == $column) {
                    $field_name = Input::get('field_name');
                    $provider = EaseProvider::where('_id', $ease_provider_id)->where($field_name, $field_name)->get()->toJson();
                    return $provider;
                }}
                if ($input->field_name == "gender" || $input->field_name == "rating" || $input->field_name == "wallet") {
                    $field_name = Input::get('field_name');
                    $provider = EaseUser::where('_id', $user_id)->where($field_name, $field_name)->get()->toJson();
                    return $provider;
                } else {
                    $field_name = $input->field_name;
                    $UserId = EaseUser::where('_id', $ease_user_id)->get();
                    //$ease_user_id is the column field of EaseProvider
                    $Tuser_id = $UserId[0]->user_id;
                    $user = User::where('id', $Tuser_id)->get();
                    //$user_id is the user_id column of user
                    $user_id = $user[0]->_id;
                    $provider = User::where('id', $user_id)->where($field_name, $field_name)->get()->toJson();
                    return $provider;
                }

        }
        else{
            $provider=[];
            $apikey = Input::get('apikey');

            $user = User::where('apikey',$apikey)->get();

            $provider['email']=$user[0]->email;
            $provider['password']=$user[0]->password;
            $provider['mobile']=$user[0]->mobile;
            $provider['apikey']=$user[0]->apikey;
            $provider['name']=$user[0]->name;

            $ease_user = EaseUser::where('user_id',$user[0]->id)->get();

            $provider['verified']=$ease_user[0]->verified;
            $provider['nationality']=$ease_user[0]->nationality;
            $provider['gender']=$ease_user[0]->gender;
            $provider['rating']=$ease_user[0]->rating;
            $provider['number_of_ratings']=$ease_user[0]->number_of_reviews;
            $provider['wallet']=$ease_user[0]->wallet;
            $provider['national_iqama_id']=$ease_user[0]->national_iqama_id;

            $ease_provider = EaseProvider::where('ease_user_id',$ease_user[0]->_id)->get();
            $ease_documents = EaseUploadedDocument::where('ease_user_id',$easeUserId[0]->_id)->get();

            if(count($ease_documents) !=0){
                foreach($ease_documents as $ease_document){
                    if($ease_document->document_type == "national_id"){
                        $provider['national_id']=$ease_document->url;
                    }
                    else{
                        $provider['profile']=$ease_document->url;
                    }

                }
            }
            $provider['pending_commission']=$ease_provider[0]->pending_commission;
            $provider['amount_withdrew']=$ease_provider[0]->amount_withdrew;
            $provider['commission_paid_to_company']=$ease_provider[0]->commission_paid_to_company;
            $provider['services']=[];

            $providerServices = EaseProviderService::where('ease_provider_id',$ease_provider[0]->_id)->get();
            if(isset($providerServices)){
                foreach ($providerServices as $providerService){
                    $ease_service_id = $providerService->ease_service_id;
                    $temp_services = EaseService::where('_id',$ease_service_id)->get();
                    foreach ($temp_services as $temp_service){
                        array_push($provider['services'],$temp_service->name);
                    }
                }
            }

            return json_encode($provider);
        }
        return json_encode($provider);
    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postUpdateProvider() {
        $input = (Object)Input::all();
        //id is the id of the ease_provider
        $apikey = Input::get('apikey');
        $user = User::where('apikey',$apikey)->get();
        $user_email = $user[0]->email;
        $ease_user = EaseUser::where('user_id',$user[0]->id)->get();
        $pro = EaseProvider::where('ease_user_id',$ease_user[0]->_id)->first();
        $providerId = $pro->_id;
        $easeProviderInstance = [];
        $easeProviderInstance['_id']=$providerId;
        if(Input::has('pending_commission')){
            $easeProviderInstance['pending_commission']=$input->pending_commission;
        }
        if(Input::has('amount_withdrew')){
            $easeProviderInstance['amount_withdrew']=$input->amount_withdrew;
        }
        if(Input::has('commission_paid_to_company')){
            $easeProviderInstance['commission_paid_to_company']=$input->commission_paid_to_company;
        }
        if(Input::has('is_available')){
            $easeProviderInstance['is_available']=$input->is_available;
        }
        if(Input::has('ease_service_id')){
            $ser = $input->ease_service_id;
            $temp_services = EaseProviderService::where('ease_provider_id',$providerId);
            $temp_services->delete();
            $services = (explode("_",$ser));
            //$ease_user_id is the column field of EaseProvider
            //$ease_user_id= $response[0]->ease_user_id;
            foreach($services as $service){
                $instance=[];
                $instance['ease_provider_id']=$providerId;
                $instance['ease_service_id']=$service;
                EaseProviderService::store($instance);
            }
        }
        $provider = EaseProvider::store($easeProviderInstance);
        //getting EaseProvider instance
        $easeUserId= EaseProvider::where('_id',$providerId)->get();

        //$ease_user_id is the column field of EaseProvider
        $ease_user_id= $easeUserId[0]->ease_user_id;
        $user=EaseUser::where('_id',$ease_user_id)->get();
        //$user_id is the user_id column of user
        $user_id=$user[0]->user_id;

        $easeUserInstance = [];
        $easeUserInstance['_id']=$ease_user_id;
        if(Input::has('rating')){
            $easeUserInstance['rating']=$input->rating;
        }
        if(Input::has('verified')){
            $easeUserInstance['verified']=$input->verified;
        }
        if(Input::has('gender')){
            $easeUserInstance['gender']=$input->gender;
        }
        if(Input::has('wallet')){
            $easeUserInstance['wallet']=$input->wallet;
        }
        EaseUser::store($easeUserInstance);

        //below is the user instance
        if(!(Input::has('email'))){
            $response=[];
            $response['status']='failed';
            $response['data']="email is not provided";
            return $response;
        }
        $AUserInstance['email']=$user_email;
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
            $user = User::where('email',$input->email)->first();
            $userid = $user->id;
            $username = $user->name;
            $profile=$userid."_".$username.".jpeg";
            $filePath = "http://103.196.221.22/php/ease/public/profile/".$profile;
            $tempdocument = EaseUploadedDocument::where('document_type','profile')->where('ease_user_id',$providerId)->delete();
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
            $easeUploadedDocumentInstance['ease_user_id']=$providerId;
            $easeUploadedDocumentInstance['document_type']='profile';
            $easeUploadedDocumentInstance['profile']=$profile;
            $easeUploadedDocumentInstance['url']=$filePath;
            $res = EaseUploadedDocument::store($easeUploadedDocumentInstance);
        }
        $response = [];
        $response['status']="success";
        return $response;
    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postAcceptServiceRequest() {

        $inputt = (object)Input::all();
        $ease_service_request_id = $inputt->service__id;
        $ease_provider_id = $inputt->provider_id;
        $input=[];
        $input['lat']=$inputt->lat;
        $input['lng']=$inputt->lng;
        $input['action'] = "approved";
        $input['ease_provider_id']=$ease_provider_id;
        $input['ease_service_request']=$ease_service_request_id;

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
        //here we have to check if the the required numbers of providers have registered if yes then create a record in the ease_provider_service_request
        $response = EaseProviderServiceRequest::store($input);
        $providers = EaseProviderServiceRequest::where('ease_service_request_id',$ease_service_request_id)->get();

        $numberOfProviders = count($providers);
        $numberOfProvidersNeeded = EaseServiceRequest::where('_id',$ease_service_request_id)->get('number_of_providers');

        if($numberOfProviders==$numberOfProvidersNeeded) {
            //number of providers equal to query result then mark is scheduled
            //insert a timestamp in is_scheduled in ease_service_requests
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
            $timestamp= Dates::now();
            $addRow = [];
            $addRow['is_scheduled'] = $timestamp;
            $response = EaseServiceRequest::store($addRow);
            echo json_encode($response);
        }
        return $response['status']="success";

    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postMarkPaid() {
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
        $timestamp= Dates::now();
        $input->changed_at=$timestamp;
        $input->status="completed";
        $response = EaseServiceRequest::store($input);

        //storing a record in ease_service_payment
        $service_request = $input->ease_service_request_id;
        $seeker_id = $service_request->ease_seeker_id;
        $provider_id = $service_request->ease_provider_id;
        $inputPayment = new EaseServicePayment();
        $inputPayment['ease_seeker_id']=$seeker_id;
        $inputPayment['ease_provider_id']=$provider_id;
        $inputPayment['ease_service_request_id']=$service_request;

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
        $response = EaseServicePayment::store($inputPayment);
    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postWithdrawPayment() {
        $input = (object)Input::all();
        //will do later as is related to wallet
    }
    //-------------------------------------------------------
    function postPayCommission() {

        $input = (object)Input::all();
        $timestamp= Dates::now();
        $input->performed_at=$timestamp;
        $input->status="success";

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
        $response = EaseCommissionPayment::store($input);
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