<?php

class SettingController extends BaseController
{

    public $data;

    public function __construct()
    {

        $this->data = new stdClass();
        $this->data->prefix = "setting";

        $this->data->table = 'settings';
        $this->data->input = (object)Input::all();
        $this->data->model = "Setting";
        $this->data->view = "core::setting.";
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    function update()
    {
        foreach($this->data->input as $key => $val)
        {
            $setting = Setting::where('key', '=', $key)->first();
            $setting->value = $val;
            $setting->save();
        }

        return Redirect::back()->with('flash_success', constant('core_success'));

    }
    //--------------------------------------------------------------------


    //--------------------------------------------------------------------

} // end of class