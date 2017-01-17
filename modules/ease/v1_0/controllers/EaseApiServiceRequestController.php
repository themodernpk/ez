<?php

class EaseApiServiceRequestController extends BaseController
{
    public $data;
    public $settings;

    public function __construct()
    {
        
        $this->data->model = $this->settings->model;
        $this->data->rows = $this->settings->rows;
        $this->data->view = $this->settings->view;
        $this->data->settings = $this->settings;
    }
    //-------------------------------------------------------
    function getServiceRequestListNearBy() {
        $input = (Object)Input::all();
        $flat = $input->lat;
        $flng = $input->lng;
        $city=$input->city;
        $provider_id = $input->provider_id;
        $ease_provider=EaseProvider::where('_id',$provider_id)->get();

        $service_with_cities=[];
        $serviceRequests=[];
        $services_with_cities=EaseServiceRequest::where('city',$city)->get();

        //checking if the the service is approved
        foreach ($services_with_cities as $services_with_city) {
            $service_city_id = $services_with_city['_id'];
            $easeProvider_service_requests= EaseProviderServiceRequest::where('_id',$service_city_id)->get();
            foreach($easeProvider_service_requests as $easeProvider_service_request){

                if($easeProvider_service_request['action']="approved"){
                    array_push($service_with_cities,$services_with_city);
                }
            }
        }
        $ease_provider_services = EaseProviderService::where('ease_provider_id',$provider_id)->get();

        foreach ($ease_provider_services as $ease_provider_service){
            foreach ($service_with_cities as $service_with_city){
                if($service_with_city['ease_service_id']==$ease_provider_service['ease_service_id']){
                    if($service_with_city['ease_profession_level_id']==$ease_provider){
                        array_push($serviceRequests,$service_with_city);
                    }
                }
            }
        }
        /*$provider_id = $input->provider_id;
        $ease_provider_services = EaseProviderService::where('ease_provider_id',$provider_id)->get();
        $serviceRequests = [];
        $distance_diameter = EaseSetting::where('name','diameter')->get();*/
        //the locations variable will be array of four columns lat, lng , _id and the distance with the provider of the service
        /*$locations= DB::table('service_service_requests')
            ->select(
                'lat',
                'lng',
                '_id',
                DB::raw('SQRT(POW(69.1 * (lat - '.$flat.'), 2) +POW(69.1 * ('.$flng.' - lng) * COS(lat / 57.3), 2)) AS distance'));*/
        //===============================
        //creating an array to store all the list of service requests
        //===============================
        /*$services_provided_by_provider=[];
        foreach ($ease_provider_services as $ease_provider_service) {
            array_push($services_provided_by_provider,$ease_provider_service['ease_service_id']);
        }*/
        /*//===============================
        foreach ($locations as $location) {
            //selecting by provider_id
            if($location[distance]<$distance_diameter){
                //if matched then select by service id
                foreach ($services_provided_by_provider as $r){
                    $request = EaseServiceRequest::where('_id',$location[_id])->get();
                    if($request['ease_service_id']==$r){
                        //if true push in the array
                        $request = EaseServiceRequest::where('_id',$location[_id])->get()->toJson();
                        array_push($serviceRequests,$request);
                    }
                }
            }
        }*/
        return $serviceRequests;
    }
    //-------------------------------------------------------
    function postServiceRequestBy() {
        $input = (Object)Input::all();
        $service_id=$input->service_id;
        $serviceRequestListNearBy = EaseServiceRequest::where('ease_service_id',$service_id)->get()->toJson();
        return $serviceRequestListNearBy;
    }
    //-------------------------------------------------------
    function postSeekerServiceRequestHistory() {
        $input = (Object)Input::all();
        $seeker_id=$input->seeker_id;
        $serviceRequestHistory = EaseServiceRequest::where('ease_seeker_id',$seeker_id)->toJson();
        return $serviceRequestHistory;
    }
    //-------------------------------------------------------
    function postProviderRequestHistory() {
        $input=(Object)Input::all();
        $provider_id=$input->provider_id;
        $serviceRequestHistory = EaseProviderServiceRequest::where('ease_provider_id',$provider_id)->toJson();
        return $serviceRequestHistory;
    }
    //-------------------------------------------------------
    function postServiceRequestLogTime() {
        $input=(Object)Input::all();
        $request_id=$input->ease_service_request_id;
        $serviceRequestLogTime = EaseServiceTimelog::where('ease_service_request_id',$request_id)->toJson();
        return $serviceRequestLogTime;
    }
    //-------------------------------------------------------
    function postCurrentProviderCount() {
        $input=(Object)Input::all();
        $service_request_id=$input->ease_service_request_id;
        $providers = EaseProviderServiceRequest::where('ease_service_request_id',$service_request_id)->get();
        $numberOfProvider = count($providers);
        return $numberOfProvider;
    }
    //-------------------------------------------------------
    //-------------------------------------------------------
    function postStartService() {
        $input=(Object)Input::all();
        $ease_service_request_id=$input->ease_service_request_id;
        $easeServiceTimeLog=[];
        $easeServiceTimeLog['ease_service_request_id']=$ease_service_request_id;
        $timestamp= Dates::now();
        $easeServiceTimeLog['start_time']=$timestamp;
        $easeServiceTimeLog['status']='going_on';

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
        $response = EaseServiceTimeLog::store($easeServiceTimeLog);
        echo json_encode($response);
        die();
        return $responce;
    }
    //-------------------------------------------------------
    function postStopService() {
        $input=(Object)Input::all();
        $ease_service_request_id=$input->ease_service_request_id;
        $easeServiceTimeLog=[];
        $easeServiceTimeLog['ease_service_request_id']=$ease_service_request_id;
        $timestamp= Dates::now();
        $easeServiceTimeLog['stop_time']=$timestamp;
        $easeServiceTimeLog['status']='complete';

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
        $response = EaseServiceTimeLog::store($easeServiceTimeLog);
        echo json_encode($response);
        die();
        return $responce;
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