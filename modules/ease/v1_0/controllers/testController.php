<?php
/**
 * Created by PhpStorm.
 * User: taranjeet.s
 * Date: 1/18/2017
 * Time: 10:54 AM
 */
class TestController extends BaseController{
    public function test(){
        $input=(Object)Input::all();
        $provider_id = $input->provider_id;
        $provider = EaseReportIssue::find('587f00fbab469b1f22678413')->ease_provider();
        //$providers = EaseProvider::where('_id',$provider_id)->first();
        //return $providers->ease_report_issues();
        return json_encode($provider);
    }
}