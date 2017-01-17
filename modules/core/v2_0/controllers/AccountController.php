<?php

/**
 * Created by PhpStorm.
 * User: pradeep
 * Date: 2014-12-13
 * Time: 10:48 PM
 */
class AccountController extends BaseController
{
    /* ****** Code Completed till 10th april */
    public static $view = 'core::account.core-account';

    public function __construct()
    {
    }

    //------------------------------------------------------
    function updateAccount()
    {
        $response = User::updateAccount();
        echo json_encode($response);
        die();
    }

    //------------------------------------------------------
    function getProfile()
    {
        $data = array();
        $id = Request::segment(3);
        if (!isset($id)) {
            $id = Auth::user()->id;
        } else {
            $user_id = Auth::user()->id;
            if ($id != $user_id) {
                if (!Permission::check('can-see-others-profile-section')) {
                    return Redirect::route('error')->with('flash_error', "You don't have permission to view this page");
                }
            }
        }
        $data['user'] = User::findorFail($id);
        return View::make(self::$view . '-profile')->with('title', 'Profile')->with('data', $data);
    }

    //------------------------------------------------------
    function getActivities()
    {
        $input = Input::all();
        //if start and end is set
        if (Input::has('start') && Input::has('end')) {
            $data['list'] = Activity::where("user_id", Auth::user()->id)->whereBetween('created_at', array($input['start'], $input['end']))->get();
        } else {
            $data['list'] = Activity::where("user_id", Auth::user()->id)->get();
        }
        return View::make(self::$view . '-activities')->with('title', 'My Activity Log')->with('data', $data);
    }

    // ................................................
    function getNotifications()
    {
        $input = Input::all();
        //if start and end is set
        if (Input::has('start') && Input::has('end')) {
            $data['list'] = Notification::where("user_id", Auth::user()->id)->whereBetween('created_at', array($input['start'], $input['end']))->get();
        } else {
            $data['list'] = Notification::where("user_id", Auth::user()->id)->get();
        }
        return View::make(self::$view . '-notifications')->with('title', 'My Notifications')->with('data', $data);
    }

    //------------------------------------------------------
    function getSettings()
    {
        $data = array();
        return View::make(self::$view . '-settings')->with('title', 'Setting ')->with('data', $data);
    }

    //------------------------------------------------------
    function getIndex()
    {
        $data = array();
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        $data['user'] = $user;
        return View::make(self::$view)->with('title', 'Account Details')->with('data', $data);
    }
} // end of the class