<?php

class EaseProviderController extends BaseController
{
    public $data;
    public $settings;

    public function __construct()
    {
        $this->data = new stdClass();
        $this->settings = EaseProvider::getSettings();
        $this->data->prefix = $this->settings->prefix;
        $this->data->input = (object)Input::all();
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-read')) {
                $error_message = "You don't have permission to view this page";
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
        $this->data->model = $this->settings->model;
        $this->data->rows = $this->settings->rows;
        $this->data->view = $this->settings->view;
        $this->data->settings = $this->settings;
    }

    //------------------------------------------------------
    function index()
    {
        $model = $this->data->model;
        if (isset($this->data->input->show) && $this->data->input->show == 'trash') {
            $this->data->list = $model::getTrash();
        } else {
            if (isset($this->data->input->q) && !empty($this->data->input->q)) {
                $this->data->list = $this->search();
            } else {
                $list = $model::orderBy("created_at", "ASC")->get();
                foreach ($list as $list_item){

                    $ease_user = EaseUser::where('_id',$list_item->ease_user_id)->first();
                    if(count($ease_user) !== 0){
                        $list_item->verified=$ease_user->verified;
                        $list_item->gender=$ease_user->gender;
                        $list_item->rating=$ease_user->rating;
                        $list_item->wallet=$ease_user->wallet;
                        $list_item->national_iqama_id=$ease_user->national_iqama_id;
                        $list_item->profession_level=$ease_user->profession_level;
                    }
                    $ease_documents = EaseUploadedDocument::where('ease_user_id',$list_item->_id)->get();
                    if(count($ease_documents) !=0){
                        foreach($ease_documents as $ease_document){
                            if($ease_document->document_type == "national_id"){
                                $list_item->national_id=$ease_document->url;
                            }
                            else{
                                $list_item->profile=$ease_document->url;
                            }
                        }
                    }
                    $user = User::where('id',$ease_user->user_id)->first();
                    if(count($user) !== 0){
                        $list_item->email=$user->email;
                        $list_item->password=$user->password;
                        $list_item->mobile=$user->mobile;
                        $list_item->apikey=$user->apikey;
                        $list_item->name=$user->name;
                    }
                }
                $listt=(Array)$list;
                $this->data->list = Paginator::make($listt,null,$this->data->rows);
            }
        }
        $this->data->trash_count = $model::getTrashCount();
        return View::make($this->data->view . 'index')->with('title', 'Provider List')->with('data', $this->data);
    }

    //------------------------------------------------------
    function search()
    {
        $model = $this->data->model;
        $list = $model::orderBy("created_at", "ASC");
        $term = $this->data->input->q;
        $list->where('question', 'LIKE', '%' . $term . '%');
        $list->orWhere('slug', 'LIKE', '%' . $term . '%');
        $list->orWhere('_id', '=', $term);
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
        $res = EaseProvider::where('_id',$id)->get();
        //uploaded documents
        $documents = EaseUploadedDocument::where('ease_user_id',$res[0]->_id)->get();
        $ease_user_id = $res[0]->ease_user_id;
        $resp =Easeuser::where('_id',$ease_user_id)->get();
        $userObject = User::where("id",$resp[0]->user_id)->first();

        $model = $this->data->model;
        $item = $model::withTrashed()->where('_id', $id)->first();
        if ($item) {
            if(count($documents) !=0){
                foreach($documents as $document){
                    if($document->document_type == "national_id"){
                        $provider['national_id']=$document->url;
                    }
                    else{
                        $provider['profile']=$document->url;
                    }
                }
            }
            $item->verified = $resp[0]->verified;
            $item->gender = $resp[0]->gender;
            $item->rating = $resp[0]->rating;
            $item->wallet = $resp[0]->wallet;
            $item->national_iqama_id = $resp[0]->national_iqama_id;
            $item->email_verification_code = $resp[0]->email_verification_code;
            $item->number_of_reviews=$resp[0]->number_of_reviews;
            $item->nationality=$resp[0]->nationality;

            $item->name=$userObject->name;
            $item->mobile=$userObject->mobile;
            $item->email=$userObject->email;

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
    function updateFullProvider(){
        $input = (Object)Input::all();
        $id = $input->ease_user_id;
        $usersEmail = $input->email;
        $providerId = EaseProvider::where('ease_user_id',$id)->get();
        $easeProviderInstance= [];
        $easeProviderInstance['_id']=$providerId[0]->_id;
        if(Input::has('amount_withdrew')){
            $easeProviderInstance['amount_withdrew']=$input->amount_withdrew;
        }
        if(Input::has('pending_commission')){
            $easeProviderInstance['pending_commission']=$input->pending_commission;
        }
        if(Input::has('commission_paid_to_company')){
            $easeProviderInstance['commission_paid_to_company']=$input->commission_paid_to_company;
        }
        if(Input::has('profession_level')){
            $easeProviderInstance['profession_level']=$input->profession_level;
        }
        $seeker = EaseProvider::store($easeProviderInstance);
        //getting EaseProvider instance
        $easeUserId= EaseProvider::where('_id',$providerId[0]->_id)->get();
        //$ease_user_id is the column field of EaseProvider
        $ease_user_id= $easeUserId[0]->ease_user_id;
        $user=EaseUser::where('_id',$ease_user_id)->get();
        //$user_id is the user_id column of user
        $user_id=$user[0]->user_id;
        $easeUserInstance = [];
        $easeUserInstance['_id']=$user[0]->_id;
        if(Input::has('gender')){
            $easeUserInstance['gender']=$input->gender;
        }
        if(Input::has("action")){
            $easeUserInstance['verified']=$input->action;
        }
        if(Input::has("rating")){
            $easeUserInstance['rating']=$input->rating;
        }
        if(Input::has("wallet")){
            $easeUserInstance['wallet']=$input->wallet;
        }
        $res = EaseUser::store($easeUserInstance);

        //below is the user instance
        $user = User::where('id',$user_id)->first();
        $userInstance=[];
        $userInstance['id']=$user->id;

        if(Input::has('name')){
            $userInstance['name']=$input->name;
        }
        if(Input::has('mobile')){
            $userInstance['mobile']=$input->mobile;
        }
        $res = User::store($userInstance);

        $response=[];
        $response['status']='success';
        return json_encode($response);

    }
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
                $input['_id'] = $id;
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
            $input['_id'] = $this->data->input->pk;
            $input['enable'] = 0;
            $response = $model::store($input);
            echo json_encode($response);
            die();
        } else if (is_array($this->data->input->_id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $input['_id'] = $id;
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
                    $model::withTrashed()->where('_id', $id)->restore();
                }
                return Redirect::back()->with('flash_success', constant('core_msg_permission_denied'));
                break;
            //------------------------------
            case 'permanent_delete':
                foreach ($this->data->input->id as $id) {
                    $model::withTrashed()->where('_id', $id)->forceDelete();
                }
                return Redirect::back()->with('flash_success', constant('core_success_message'));
                break;
            //------------------------------
        }
    }
    //------------------------------------------------------
    public function readData() {
        $input = (Object)Input::all();
        $ease_provider_id = $input->id;
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
            $provider['gender']=$ease_user[0]->gender;
            $provider['rating']=$ease_user[0]->rating;
            $provider['wallet']=$ease_user[0]->wallet;
            $provider['national_iqama_id']=$ease_user[0]->national_iqama_id;

            $ease_provider = EaseProvider::where('ease_user_id',$ease_user[0]->_id)->get();

            $provider['pending_commission']=$ease_provider[0]->pending_commission;
            $provider['amount_withdrew']=$ease_provider[0]->amount_withdrew;
            $provider['commission_paid_to_company']=$ease_provider[0]->commission_paid_to_company;

            return json_encode($provider);
        }
        return json_encode($provider);
    }
    //------------------------------------------------------
} // end of the class