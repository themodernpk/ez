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

                {{ Form::open(array('route' => 'postregister', 'class' =>'form-horizontal', 'role' => 'form')) }}

                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" value="{{Input::old('name')}}" name="name"
                           placeholder="Full Name"/>
                </div>

                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" value="{{Input::old('email')}}" name="email"
                           placeholder="Email Address"/>
                </div>

                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" name="password" placeholder="Password"/>
                </div>


                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" value="{{Input::old('mobile')}}" name="mobile"
                           placeholder="Mobile Number"/>
                </div>



                <div class="login-buttons">
                    <button type="submit" class="btn btn-success ">Sign Up</button>
                    <a href="{{URL::route('login')}}" class="btn btn-info">Sign In</a>
                </div>
                <div class="checkbox m-b-20">

                    <span class="pull-right"><a href="{{URL::route('forgot-password')}}">Forgot Password?</a></span>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <!-- end login -->

    </div>
    <!-- end page container -->
@stop

@section('page_specific_foot')
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
@stop