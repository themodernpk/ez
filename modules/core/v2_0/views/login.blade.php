@extends('core::layout.core')

@section('content')
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> {{Setting::value('app-name')}}
                    <small>{{constant('core_app_licensed')}}</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">

                @include('core::layout.inc.error_msg')
                @include('core::layout.inc.flash_msg')

                {{ Form::open(array('route' => 'postlogin', 'class' =>'margin-bottom-0', 'role' => 'form')) }}

                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" value="{{Input::old('email')}}" name="email"
                           placeholder="Email Address"
                    id="anemailid"/>
                </div>
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" name="password" placeholder="Password"
                    id="anpasswordid"/>
                </div>
                <div class="checkbox m-b-20">
                    <label>
                        <input type="checkbox" name="remember"/> Remember Me
                    </label>
                    <span class="pull-right"><a href="{{URL::route('forgot-password')}}">Forgot Password?</a></span>
                </div>
                <div class="login-buttons">
                    <button type="submit" class="btn btn-success ">Sign me in</button>
                    {{--<a href="{{URL::route('register')}}" class="btn btn-info">Sign up</a>--}}
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <!-- end login -->


    </div>
    <!-- end page container -->
@stop
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.4/firebase.js"></script>

<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyBXIlkKT2OVQzxSJNpsq2xfz5VNyjhBFg8",
        authDomain: "easehomehelp-ce4a5.firebaseapp.com",
        databaseURL: "https://easehomehelp-ce4a5.firebaseio.com",
        storageBucket: "easehomehelp-ce4a5.appspot.com",
        messagingSenderId: "998984741364"
    };
    firebase.initializeApp(config);
</script>

<script>
    $(document).ready(function() {
        var email="wri@webreinvent.com";
        var password="wri12345";
        console.log("ready");
        $("#anemailid").focusout(function(){
            email=$(this).val();
            console.log(email);

            const auth = firebase.auth();
            const promise = auth.signInWithEmailAndPassword(email,password);
            promise.then(function() {
                console.log("successfully logged in");
            });
            promise.catch(function(e) {
                console.log(e.message);
            });
        });
        $("#anpasswordid").focusout(function(){
            password=$(this).val();
            console.log(password);

        });

        const auth = firebase.auth();
        const promise = auth.signInWithEmailAndPassword(email,password);
        promise.then(function() {
            console.log("successfully logged in");
        });
        promise.catch(function(e) {
            console.log(e.message);
        });
    });

</script>--}}
@section('page_specific_foot')
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
@stop