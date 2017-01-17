<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EaseApiPublicController extends BaseController
{
    public $data;
    public $settings;

    public function __construct()
    {
        $this->data = new stdClass();
        $this->settings = EaseApiPublic::getSettings();
        $this->data->prefix = $this->settings->prefix;
        $this->data->input = (object)Input::all();

        $this->data->model = $this->settings->model;
        $this->data->rows = $this->settings->rows;
        $this->data->view = $this->settings->view;
        $this->data->settings = $this->settings;
    }
    //------------------------------------------------------
    function postLogin() {
        $input = (object)Input::all();
        $email = $input->email;
        $password=$input->password;
        $response=[];

        if (Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            $apikey = Auth::user()->apikey;
            $group_id = Auth::user()->group_id;
            $id = Auth::user()->id;
            $name= Auth::user()->name;
            if($group_id==2) {
                $easeUserId= EaseUser::where('user_id',$id)->get();
                //$ease_user_id is the column field of EaseUser
                $approved= $easeUserId[0]->verified;
                $ease_user_id = $easeUserId[0]->_id;
                //geting user from verification table
                $easeUserId= EaseUserVerification::where('ease_user_id',$ease_user_id)->get();
                //$ease_user_id is the column field of EaseUser
                $is_email_verified= $easeUserId[0]->email;
                if(!$is_email_verified) {
                    $response['verification_status']="VerificationEmailPending";
                }
                $document_status = $easeUserId[0]->documents;
                if($is_email_verified && $approved="resend") {
                    $response['verification_status']="VerificationDocPending";
                }
                if($is_email_verified && $document_status=="approved" && $approved =="false"){
                    $response['verification_status']="VerificationDocDenied";
                }
                if($is_email_verified && $document_status=="approved" && $approved==true){
                    $response['verification_status']="VerificationDocApproved";
                }
                $response['user-type']='provider';
                $response['apikey']=$apikey;
                $response['name']=$name;
                $response['is_approved'] = $approved;
                return json_encode($response);

            }
            if($group_id==3) {

                $easeUserId= EaseUser::where('user_id',$id)->get();
                //$ease_user_id is the column field of EaseUser
                $approved= $easeUserId[0]->verified;
                $ease_user_id = $easeUserId[0]->_id;
                //geting user from verification table
                $easeUserId= EaseUserVerification::where('ease_user_id',$ease_user_id)->get();
                //$ease_user_id is the column field of EaseUser
                $is_email_verified= $easeUserId[0]->email;
                $document_status = $easeUserId[0]->documents;
                $response['user-type']='seeker';
                //$response['is_approved'] = $approved;
                if(!$is_email_verified) {
                    $response['verification_status']="VerificationEmailPending";
                }
                $document_status = $easeUserId[0]->documents;
                if($is_email_verified && $approved=="resend") {
                    $response['verification_status']="VerificationDocPending";
                }
                if($is_email_verified && $document_status=="approved" && $approved=="false"){
                    $response['verification_status']="VerificationDocDenied";
                }
                if($is_email_verified && $document_status=="approved" && $approved=="true"){
                    $response['verification_status']="VerificationDocApproved";
                }
                $response['is_approved'] = $approved;
                $response['apikey']=$apikey;
                $response['name']=$name;
                return json_encode($response);

            }

            if($group_id==1)
            {
                $response['user-type']="admin";
            }

            $response['status']="success";
            $response['apikey']=$apikey;

            return json_encode($response);
        }
        else{
            $response['status']="failed";
            $response['error']="Invalid email/password";
            return $response;
        }

    }
    //------------------------------------------------------
    function testEmail() {
        Mail::send('ease::email.test', array('key' => 'value'), function($message)
        {
            $message->to('taranjeet.wri76@webreinvent.com', 'taranjeet singh')->subject('Welcome!');
        });
    }
    //------------------------------------------------------
    function getServiceList() {
        $professionLevelList = EaseService::all()->toJson();
        return $professionLevelList;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getProfessionList() {
        $input = (object)Input::all();
        $response=[];
        if(isset($input->service_id)){
            $service_id = $input->service_id;
        }
        else{
            $response['status']='failed';
            $response['data']="service_id is required";
            return json_encode($response);
        }
        if(isset($input->country_id)){
            $country_id=$input->country_id;
        }
        else{
            $response['status']='failed';
            $response['data']="country_id is required";
            return json_encode($response);
        }
        $prices = EaseProfessionLevel::where('service_id',$service_id)->where('country_id',$country_id)->get();
        foreach($prices as $price){
            array_push($response,$price);
        }
        return json_encode($response);
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getCountryList() {
        $countryList = EaseCountry::all()->toJson();
        return $countryList;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getOffers() {
        $offers=(Array)EaseOffer::all();
        foreach ($offers as $offer) {
            $service_id = $offer[0]->offer_for;
            $ser = EaseService::where('_id',$service_id)->get();
            $offer[0]->offer_for = $ser[0]->name;
        }
        return json_encode($offers);
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getFaq() {
        $faq = EaseFaq::all()->toJson();
        return $faq;
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getTnc() {
        $input=(Object)Input::all();
        $for = $input->for;
        return $response=EaseTnc::where('tnc_for',$for)->get()->toJson();
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function getSettingKeyValue() {
    }
    //------------------------------------------------------
    function index()
    {
        /*$model = $this->data->model;
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
        return View::make($this->data->view . 'index')->with('title', 'Item List')->with('data', $this->data);*/
    }

    //------------------------------------------------------
    function search()
    {
        /*$model = $this->data->model;
        $list = $model::orderBy("created_at", "ASC");
        $term = $this->data->input->q;
        $list->where('name', 'LIKE', '%' . $term . '%');
        $list->orWhere('slug', 'LIKE', '%' . $term . '%');
        $list->orWhere('id', '=', $term);
        $result = $list->paginate($this->data->rows);
        return $result;*/
    }

    //------------------------------------------------------
    function create()
    {
        /*$this->beforeFilter(function () {
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
        die();*/
    }

    //------------------------------------------------------
    function read($id)
    {
//        $this->beforeFilter(function () {
//            if (!Permission::check($this->data->prefix . '-read')) {
//                $error_message = "You don't have permission read";
//                if (isset($this->data->input->format) && $this->data->input->format == "json") {
//                    $response['status'] = 'failed';
//                    $response['errors'][] = $error_message;
//                    echo json_encode($response);
//                    die();
//                } else {
//                    return Redirect::route('error')->with('flash_error', $error_message);
//                }
//            }
//        });
//        $model = $this->data->model;
//        $item = $model::withTrashed()->where('id', $id)->first();
//        if ($item) {
//            $item->createdBy;
//            $item->modifiedBy;
//            $item->deletedBy;
//            $response['status'] = 'success';
//            $response['data'] = $item;
//        } else {
//            $response['status'] = 'success';
//            $response['errors'][] = 'Not found';
//        }
//        if ($this->data->input->format == 'json') {
//            $response_in_json = json_encode($item);
//            $response['html'] = View::make($this->data->view . 'elements.view-item')
//                ->with('data', json_decode($response_in_json))
//                ->render();
//            echo json_encode($response);
//            die();
//        } else {
//            return $response;
//        }
    }

    //------------------------------------------------------
    function update()
    {
        /*$this->beforeFilter(function () {
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
        die();*/
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function enable()
    {
        /*$model = $this->data->model;
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
        }*/
    }

    //------------------------------------------------------
    function disable()
    {
       /* $model = $this->data->model;
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
        }*/
    }

    //------------------------------------------------------
    function delete()
    {
       /* $model = $this->data->model;
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
        }*/
    }

    //------------------------------------------------------
    function bulkAction()
    {
        /*$model = $this->data->model;
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
        }*/
    }
    //------------------------------------------------------
    //------------------------------------------------------
}