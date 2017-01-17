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
                <h3 class="text-white lead">Recover your password</h3>
                @include('core::layout.inc.error_msg')
                @include('core::layout.inc.flash_msg')

                {{ Form::open(array('route' => 'forgot-password-post', 'class' =>'margin-bottom-0', 'role' => 'form')) }}


                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" name="email"
                           placeholder="Email Address" required/>
                </div>

                <div class="login-buttons">
                    <button type="submit" class="btn btn-success ">Reset</button>

                    <div class="btn-group pull-right">
                    <a href="{{URL::route('login')}}" class="btn btn-success ">Login</a>
                    <a href="{{URL::route('register')}}" class="btn btn-primary ">Sign up</a>
                    </div>
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