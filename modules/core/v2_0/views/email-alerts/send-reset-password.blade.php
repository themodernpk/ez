Dear {{$data->user->name}},<br/><br/>


To reset your password <a href="{{URL::route('reset-password', array('opt' => Crypt::encrypt($data->otp)))}}">click here</a> or follow following steps:<br/>

Step 1:) visit following url:  {{URL::route('reset-password')}} <br/>
Step 2:) Enter one time password (OTP) - (without quotes): "{{$data->otp}}" <br/>
Step 3:) Enter your password and click "Reset" button

