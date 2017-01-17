<?php

class CoreSmtp
{
    //-----------------------------------------------------------
    /*
     * $from = array('email@example.com' => 'name');
     * $to = array('receiver@domain.org', 'other@domain.org' => 'A name')
     * $subject = "Testing Subject";
     * $message = "<b>Testing message</b>";
     * $smtp['hostname']
     * $smtp['username']
     * $smtp['password']
     * $smtp['port']
     * $smtp['encryption']
     */
    public static function send_email($from, $to, $subject, $message, $cc = NULL, $bcc = NULL, $default_css = true, $smtp = NULL)
    {
        $rules = array(
            "subject" => "required",
            "message" => "required",
            "to" => "required",
            "from" => "required",
        );
        $input['from'] = $from;
        $input['to'] = $to;
        $input['cc'] = $cc;
        $input['bcc'] = $bcc;
        $input['subject'] = $subject;
        $input['message'] = $message;
        //first run validation
        $validate = Validator::make($input, $rules);
        if ($validate->fails()) {
            $response['status'] = 'failed';
            $response['errors'] = $validate->messages()->all();
        }
        if (!is_array($input['from'])) {
            $response['status'] = 'failed';
            $response['errors'][] = "'from' variable should be an array of emails";
        }
        if (is_array($input['from'])) {
            foreach ($input['from'] as $email => $name) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                } else {
                    $response['status'] = 'failed';
                    $response['errors'][] = "'from' email is not valid";
                }
                if (ctype_digit($email)) {
                    $response['status'] = 'failed';
                    $response['errors'][] = "from email is not defined. From variable should be like array('from_email@example.com' => 'from name')";
                }
            }
        }
        if (!is_array($input['to'])) {
            $response['status'] = 'failed';
            $response['errors'][] = "'to' variable should be an array of emails";
        }
        if (isset($input['cc']) && !is_array($input['cc'])) {
            $response['status'] = 'failed';
            $response['errors'][] = "'cc' variable should be an array of emails";
        }
        if (isset($input['bcc']) && !is_array($input['bcc'])) {
            $response['status'] = 'failed';
            $response['errors'][] = "'bcc' variable should be an array of emails";
        }
        //set smtp details
        if ($smtp == NULL || !is_array($smtp) || empty($smtp)) {
            $smtp['hostname'] = Setting::value('core-smtp-hostname');
            $smtp['username'] = Setting::value('core-smtp-username');
            $smtp['password'] = Setting::value('core-smtp-password');
            $smtp['port'] = Setting::value('core-smtp-port');
            $smtp['encryption'] = Setting::value('core-smtp-encryption');
        }
        //get smtp details core
        $hostname = $smtp['hostname'];
        if (!$hostname) {
            $response['status'] = 'failed';
            $response['errors'][] = "Core setting for key 'core-smtp-hostname' does not exist";
        }
        $username = $smtp['username'];
        if (!$username) {
            $response['status'] = 'failed';
            $response['errors'][] = "Core setting for key 'core-smtp-username' does not exist";
        }
        $password = $smtp['password'];
        if (!$password) {
            $response['status'] = 'failed';
            $response['errors'][] = "Core setting for key 'core-smtp-password' does not exist";
        }
        $port = $smtp['port'];
        if (!$port) {
            $response['status'] = 'failed';
            $response['errors'][] = "Core setting for key 'core-smtp-port' does not exist";
        }
        if (isset($response['status']) && $response['status'] == 'failed') {
            return $response;
        }
        if ($default_css == true) {
            $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
            $cssToInlineStyles->setHTML($message);
            $css = asset_path() . "/email-alerts.css";
            $css = @file_get_contents($css);
            $cssToInlineStyles->setCSS($css);
            $input['message'] = $cssToInlineStyles->convert();
        } else {
            $input['message'] = $message;
        }
        try {
            $encryption = $smtp['encryption'];
            if ($encryption) {
                $transport = Swift_SmtpTransport::newInstance($hostname, $port, $encryption);
            } else {
                $transport = Swift_SmtpTransport::newInstance($hostname, $port);
            }
            $transport->setUsername($username);
            $transport->setPassword($password);
            $mailer = Swift_Mailer::newInstance($transport);
            //create message
            $message = Swift_Message::newInstance($input['subject']);
            $message->setContentType("text/html");
            $message->setFrom($input['from']);
            $message->setTo($input['to']);
            if (isset($input['cc'])) {
                $message->setCc($input['cc']);
            }
            if (isset($input['bcc'])) {
                $message->setBcc($input['bcc']);
            }
            $message->setBody($input['message']);
            try {
                $result = $mailer->send($message, $fail);
                $response['status'] = 'success';
                $response['data'][] = $result;
                return $response;
            } catch (Exceptions $e) {
                $response['status'] = 'failed';
                $response['errors'][] = $e->getMessage();
                return $response;
            }
        } catch (Exception $e) {
            $subject = $username . " - Error in sending mails via SMTP";
            $message = "Dear Admin,

            This is to inform you that Core SMTP setting:

            Username: {$username}

            <b>Error:</b> {$e->getMessage()}

            <b>Although, application might have used normal php function to deliver the email</b>

            URL: " . Request::url() . "
            ";
            $message = nl2br($message);
            CoreSmtp::report_to_admin($from, $subject, $message);
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }
    }

    //-----------------------------------------------------------
    //-----------------------------------------------------------
    public static function report_to_admin($from, $subject, $message)
    {
        //find admin users
        $group = Group::where('slug', '=', 'admin')->first();
        $users = User::where('group_id', $group->id)->where('active', 1)->get();
        foreach ($users as $user) {
            $to[$user->email] = $user->name;
        }
        CoreSmtp::send_email_normal($from, $to, $subject, $message);
    }

    //-----------------------------------------------------------
    public static function send_email_normal($from, $to, $subject, $message, $cc = NULL, $bcc = NULL)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        foreach ($from as $email => $name) {
            $headers .= "From: " . $name . " <" . $email . ">";
        }
        $headers .= "\r\n";
        if (isset($cc) && is_array($cc)) {
            $headers .= "Cc: ";
            foreach ($cc as $key => $cc_email) {
                if (!filter_var($cc_email, FILTER_VALIDATE_EMAIL) === false) {
                    $headers .= $cc_email . ",";
                } else {
                    $headers .= $key . ",";
                }
            }
        }
        if (isset($bcc) && is_array($bcc)) {
            $headers .= "Bcc: ";
            foreach ($bcc as $key => $bcc_email) {
                if (!filter_var($bcc_email, FILTER_VALIDATE_EMAIL) === false) {
                    $headers .= $bcc_email . ",";
                } else {
                    $headers .= $key . ",";
                }
            }
        }
        $send_to = "";
        foreach ($to as $key => $val) {
            if (!filter_var($val, FILTER_VALIDATE_EMAIL) === false) {
                $send_to .= $val . ",";
            } else {
                $send_to .= $key . ",";
            }
        }
        mail($send_to, $subject, $message, $headers);
    }
    //-----------------------------------------------------------
}// end of class