<?php
class APIProvider
{
    public static function getProvider($provider_id){
        $provider= EaseProvider::where('_id',$provider_id)->get()->toJSON();
        return $provider;
    }
}