<?php

class GroupController extends BaseController
{
    public $data;

    public function __construct()
    {
        $this->data = new stdClass();
        $this->data->prefix = "core-group";
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
        $this->data->table = 'groups';
        $this->data->input = (object)Input::all();
        $this->data->model = "Group";
        $this->data->view = "core::group.";
    }

    //------------------------------------------------------
    function index()
    {
        $model = $this->data->model;
        $rows = Config::get('core.settings.rows_to_display');
        if (isset($this->data->input->show) && $this->data->input->show == 'trash') {
            $this->data->list = $model::onlyTrashed()->paginate($rows);
        } else {
            $list = $model::orderBy("name", "ASC");
            if (isset($this->data->input->q) && !empty($this->data->input->q)) {
                $term = $this->data->input->q;
                $list->where('name', 'LIKE', '%' . $term . '%');
                $list->orWhere('slug', 'LIKE', '%' . $term . '%');
                $list->orWhere('id', '=', $term);
            }
            $this->data->list = $list->paginate($rows);
        }
        $this->data->trash_count = $model::onlyTrashed()->count();
        return View::make($this->data->view . 'index')->with('title', 'List of Groups')->with('data', $this->data);
    }

    //------------------------------------------------------
    function create()
    {
        $this->beforeFilter(function () {
            if (!Permission::check($this->data->prefix . '-create')) {
                return Redirect::route('error')->with('flash_error', "You don't have permission");
            }
        });
        $model = $this->data->model;
        $response = $model::store();
        if ($response['status'] == 'success') {
            Custom::syncPermissions();
        }
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
    function enable()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $item = $model::withTrashed()->where('id', $this->data->input->pk)->first();
            $item->active = 1;
            $item->save();
        } else if (is_array($this->data->input->id)) {
            foreach ($this->data->input->id as $id) {
                $item = $model::withTrashed()->where('id', $id)->first();
                $item->active = 1;
                $item->save();
            }
        }
    }

    //------------------------------------------------------
    function disable()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $item = $model::withTrashed()->where('id', $this->data->input->pk)->first();
            $item->active = 0;
            $item->save();
        } else if (is_array($this->data->input->id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $item = $model::withTrashed()->where('id', $id)->first();
                $item->active = 0;
                $item->save();
            }
        }
    }

    //------------------------------------------------------
    function delete()
    {
        $model = $this->data->model;
        if (isset($this->data->input->pk)) {
            $item = $model::withTrashed()->where('id', $this->data->input->pk)->first();
            $item->active = 0;
            $item->save();
            $item->delete();
        } else if (is_array($this->data->input->id)) {
            if (empty($this->data->input->id)) {
                $response['status'] = 'failed';
                $response['errors'][] = constant('core_no_item_selected');
                echo json_encode($response);
                die();
            }
            foreach ($this->data->input->id as $id) {
                $item = $model::withTrashed()->where('id', $id)->first();
                $item->active = 0;
                $item->save();
                $item->delete();
            }
        }
    }

    //------------------------------------------------------
    function bulkAction()
    {
        $model = $this->data->model;
        if ($this->data->input->action == 'search') {
            return Redirect::route($this->data->prefix . "-index", array('q' => $this->data->input->q));
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
                return Redirect::back()->with('flash_success', constant('crm_success_message'));
                break;
            //------------------------------
        }
    }
    //------------------------------------------------------
    //------------------------------------------------------
    function group_permissions($id)
    {
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
        $this->data->item = Group::find($id);
        return View::make($this->data->view . 'permissions')
            ->with('title', 'List of Permissions - ' . $this->data->item->name)
            ->with('data', $this->data);
    }

    //------------------------------------------------------
    function sync()
    {
        Custom::syncPermissions();
        $response['status'] = 'success';
        echo json_encode($response);
        die();
    }
    //------------------------------------------------------
    //------------------------------------------------------
} // end of the class