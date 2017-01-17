<?php

class ApiController extends BaseController
{

    /* ****** Code Completed till 10th april */
    public static $view = 'core::';
    var $input;

    function __construct()
    {
        $this->input = Input::all();
       // print_r($this->input);
    }

    //--------------------------------------------------------------------
    

    //--------------------------------------------------------------------
    /**
     * This function will find user details
     * from email or add new user
     * @return string
     */
    public function userCreate($input = NULL)
    {
        if($input == NULL)
        {
            $input = Input::all();
        }
        $response = User::authenticate($input);
        if($response['status'] == 'failed')
        {
            return json_encode($response);
        }

        /*$response = User::add($this->input);
        if ($response['status'] == "failed") {
            return json_encode($response);
        } else if ($response['status'] == "success") {
            $response['data'] = "User account successfully created for " . $this->input['email'];
            Activity::log("Account created for " . $this->input['email'], Auth::user()->id, 'API');
            return json_encode($response);
        }*/
    }

    //--------------------------------------------------------------------
    public function apiTest()
    {
        $url = URL::route('apiUserCreate');
        $query = "login_email=help@webreinvent.com&login_password=mac007";
        //$query = "login_email=reg@webreinvent.com&login_password=mac007";
        $query .= "&name=Registered User";
        $query .= "&email=help@webreinvent.com";
        $query .= "&password=mac007";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($errno = curl_errno($ch)) {
            echo $errno;
        }
        curl_close($ch);
        //server response
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        //json decoded response
        $response = json_decode($response);
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }

    //--------------------------------------------------------------------
    public static function apiHelp()
    {
        $data = array();
        return View::make(self::$view . "apihelp")->with('title', 'API Help')->with('data', $data);
    }

    //--------------------------------------------------------------------
    /* ******\ Code Completed till 10th april */
} // end of class