<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Setting extends Eloquent
{
    protected $connection = 'mysql';
    /* ****** Code Completed till 10th april */
    protected $guarded = array('id');
    protected $table = 'settings';
    protected $fillable = [
        'key',
        'type',
        'label',
        'value'
    ];


    //------------------------------------------------------------
    public static function value($key)
    {
        $setting = Setting::where('key', '=', $key)->first();
        if ($setting) {
            return $setting->value;
        } else {
            return false;
        }
    }

    //------------------------------------------------------------

    public static function createSettings($input= NULL)
    {

        if($input == NULL)
        {
            $input = Input::all();
        }


        $setting = new Setting();
        unset($input['_token']);
        unset($input['href']);
        unset($input['general_href']);
        unset($input['smtp_href']);


        if(!empty($input))
        {
            foreach ($input as $key => $value)
            {
                if (empty( $value['key'] ) && empty($value['group']) && empty($value['label'])&& empty($value['value']))
                {
                    $response['status'] = "failed";
                    $response['error'][] = 'Please Fill All the Required Fields';
                    return $response;
                }
                else
                {
                    $exists = array_key_exists('id', $value);
                    if($exists)
                    {
                        $setting = Setting::findorFail($value['id'] );
                        $setting->value = $value['value'];
                        $setting->save();
                    }
                    else
                    {
                        $key_exist = Setting::where('key', '=', $value['key'])->first();
                        if ($key_exist) {
                            $response['status'] = "failed";
                            $response['error'][] = 'Key already present';
                            return $response;
                        }

                       $setting = Setting::insert($value);
                    }


                }


            }

            if($setting)
            {
                $response['status'] = "success";
                $response['data'] = $setting;
                return $response;
            }
            else
            {
                $response['status'] = "failed";
                $response['errors'][]="Unable to add the settings";
                return $response;
            }
        }

    }
    //------------------------------------------------------------
    public static function getSettings()
    {
        $settings = Setting::all();
        $setting_list = $settings->groupBy('group');
        if ($setting_list) {
            return $setting_list->toArray();
        } else {
            return false;
        }
    }



}