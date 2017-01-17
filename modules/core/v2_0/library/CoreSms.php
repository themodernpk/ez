<?php


class CoreSms
{

	public static function send($mobile_numbers, $message)
	{

		$hash = Setting::value('core-sms-hash');
		if(!$hash)
		{
			$response['status'] = 'failed';
			$response['errors'][] = "SMS hash (key: core-sms-hash) for textlocal.in does not exist";
		}

		$username = Setting::value('core-sms-username');
		if(!$username)
		{
			$response['status'] = 'failed';
			$response['errors'][] = "Username (key: core-sms-username) for textlocal.in does not exist";
		}

		$sender_name = Setting::value('core-sms-sender-name');
		if(!$sender_name)
		{
			$response['status'] = 'failed';
			$response['errors'][] = "Sender name (key: core-sms-sender-name) for textlocal.in does not exist";
		}


		if(!is_array($mobile_numbers))
		{
			$response['status'] = 'failed';
			$response['errors'][] = "mobile_numbers variable should array";
		}

		if(isset($response['status']) && $response['status'] == 'failed' )
		{
			return $response;
		}
		$textlocal=new Textlocal($username, $hash);

		try{
			$result = $textlocal->sendSms($mobile_numbers, $message, $sender_name);

			$response['status'] = 'success';
			return $response;

		} catch(Exception $e)
		{
			$response['status'] = 'failed';
			$response['errors'][] = $e->getMessage();
			return $response;
		}



	}

} // end of tha class