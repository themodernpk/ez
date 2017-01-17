<?php

class NotificationController extends BaseController
{
    public $data;

    public function __construct()
    {
        $this->data = new stdClass();
        $this->data->prefix = "notification";
        $this->data->table = 'notifications';
        $this->data->input = (object)Input::all();
        $this->data->model = "Notification";
        $this->data->view = "core::notification.";
    }

    //--------------------------------------------------------------------
    function index()
    {
        $model = $this->data->model;
        $this->data->list = $model::get();
        $list = Notification::where('user_id', Auth::user()->id);
        $list->where('read', 0);
        if (isset($this->data->input->realtime)) {
            $list->whereNull('realtime');
        }
        $result = $list->get();
        if (isset($this->data->input->realtime)) {
            DB::table('notifications')
                ->where('user_id', Auth::user()->id)
                ->update(array('realtime' => 1));
        }
        $html = "";
        if (count($result) > 0) {
            $html .= View::make('core::service.notification-item')->with('item', $result)->render();
        }
        if (isset($this->data->input->markasread) == true) {
            DB::table('notifications')
                ->where('user_id', Auth::user()->id)
                ->update(array('read' => 1));
        }
        if ($this->data->input->format == 'json') {
            $response['status'] = 'success';
            $response['data']['html'] = $html;
            $response['data']['list'] = $result;
            echo json_encode($response);
            die();
        }
    }

    //--------------------------------------------------------------------
    function create()
    {
        $user_id = 1;
        $content = "Testing";
        $link = URL::route('dashboard');
        $icon = 'fa-bug bg-red';
        Notification::log($user_id, $content, $link, $icon);
    }
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
} // end of class