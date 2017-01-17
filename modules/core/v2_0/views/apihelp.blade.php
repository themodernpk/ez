@extends('core::layout.core')

@section('page_specific_head')
    <style>
        body {
            font-size: 16px;
            line-height: 25px;
        }
    </style>

    <link href="http://www.steamdev.com/snippet/css/jquery.snippet.css" rel="stylesheet"/>
@stop


@section('content')



    <div class="container ">
        <div class="email-content">

            <div class="row featurette mr_top_140">
                <div class="col-md-12">

                    <p><h4 class="text-success">Following url must be set for authentication:</h4></p>
                    <table class="table table-striped table-bordered ">
                        <tr>
                            <td width="250"><b>login_email</b></td>
                            <td>{Required} Email for validation</td>
                        </tr>
                        <tr>
                            <td><b>login_password</b></td>
                            <td>{Required} Set valid password address</td>
                        </tr>
                    </table>

                    <p><h4 class="text-success">To Create/Fetch User:</h4></p>

                    <table class="table table-striped table-bordered ">
                        <tr width="250">
                            <td><b>API URL</b></td>
                            <td>{{URL::route('apiUserCreate')}}</td>
                        </tr>

                        <tr>
                            <td><b>email</b></td>
                            <td>{Required} Set valid email address</td>
                        </tr>
                        <tr>
                            <td><b>group_id</b></td>
                            <td>{Required} | If not set than application will use default group_id</td>
                        </tr>
                        <tr>
                            <td><b>username</b></td>
                            <td>If not set than application will generator username from email</td>
                        </tr>
                        <tr>
                            <td><b>password</b></td>
                            <td>If not set than application will generator random password</td>
                        </tr>
                        <tr>
                            <td><b>name</b></td>
                            <td>If not set than application will use email</td>
                        </tr>
                        <tr>
                            <td><b>mobile</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center"><b>Following response will be generated in json format</b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>status</b></td>
                            <td>failed | success</td>
                        </tr>
                        <tr>
                            <td><b>errors</b></td>
                            <td>errors in array format</td>
                        </tr>
                        <tr>
                            <td><b>data</b></td>
                            <td>it variable will contain actuall response data</td>
                        </tr>
                    </table>

                    <p><h4 class="text-success">How to execute:</h4></p>

<pre class="php">
<?php

    $html = '
// api url
$url = "' . URL::route('apiUserCreate') . '";

// build query string
$query = "login_email=demo@email.com&login_password=demopassword";
$query .= "&name=Client Name";
$query .= "&email=passemail@gmail.com";

// execute via curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec ($ch);

if ($errno = curl_errno($ch)) {
    echo $errno;
}
curl_close ($ch);

//json decoded response
$response = json_decode($response);

';
    echo $html; ?>
</pre>

                </div>

            </div>
        </div>

    </div>

    <div class="text-center">
        <a class="btn btn-sm btn-info " href="{{URL::route('doc')}}"><i class="fa fa-angle-double-left"></i> Back</a>
    </div>
@stop

@section('page_specific_foot')

    <script src="http://www.steamdev.com/snippet/js/jquery.snippet.js"></script>
    <script>
        $(document).ready(function () {

            $("pre.php").snippet("php", {style: "golden"});


        });
    </script>

@stop