@extends('core::layout.core')

@section('page_specific_head')
@stop

@section('content')


    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> {{constant('core_app_name')}}
                    <small>{{constant('core_app_licensed')}}</small>

                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
        </div>
    </div>


    <hr/>

    <div class="container">
        <div class="row">


            <div class="col-xs-12 text-center"><h1>Application Installation</h1><br/></div>


            <!-- begin col-12 -->
            <div class="col-md-12 ui-sortable">

                @include('core::layout.inc.error_msg')
                @include('core::layout.inc.flash_msg')


                <!-- begin panel -->
                {{ Form::open(array('route' => 'postregister', 'role' => 'form')) }}
                <div class="bwizard clearfix" id="wizard">
                    <ol aria-selected="false" style="z-index: 2;" role="tablist"
                        class="bwizard-steps clearfix clickable">
                        <li role="tab"><span class="label badge-inverse">1</span><a href="#step1" class="hidden-phone">
                                Database Configuration
                            </a><a href="#step1" class="hidden-phone">
                                <small>Make sure you have already create DB & it's credentials</small>
                            </a><a href="#step1" class="hidden-phone">
                            </a></li>
                        <li aria-selected="false" style="z-index: 3;" role="tab"><span class="label">2</span><a href="#"
                                                                                                                class="hidden-phone">
                                Run Migrations & Seeds
                            </a><a href="#step2" class="hidden-phone">
                                <small>It will create database schema & insert required data.</small>
                            </a><a href="#step2" class="hidden-phone">
                            </a></li>
                        <li class="active" aria-selected="true" style="z-index: 4;" role="tab"><span
                                    class="label">3</span><a href="#step3" class="hidden-phone">
                                Create Admin Account
                            </a><a href="#step3" class="hidden-phone">
                                <small>Final step is to create first admin account</small>
                            </a><a href="#step3" class="hidden-phone">
                            </a></li>

                    </ol>
                    <!-- begin wizard step-1 -->

                    <!-- end wizard step-1 -->
                    <!-- begin wizard step-2 -->

                    <!-- end wizard step-2 -->
                    <!-- begin wizard step-3 -->

                    <!-- end wizard step-3 -->
                    <!-- begin wizard step-4 -->

                    <!-- end wizard step-4 -->
                    <div class="well">
                        <div aria-hidden="false" class="bwizard-activated" role="tabpanel" id="step1">
                            <fieldset>
                                <legend class="pull-left width-full">Enter Database Details</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <!-- begin col-4 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="First Name"
                                                   value="{{Input::old('name')}}" required>
                                        </div>
                                    </div>
                                    <!-- end col-4 -->
                                    <!-- begin col-4 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{Input::old('email')}}" placeholder="Email">
                                        </div>
                                    </div>
                                    <!-- end col-4 -->
                                    <!-- begin col-4 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="Password" required>
                                        </div>
                                    </div>
                                    <!-- end col-4 -->


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input type="text" name="mobile" class="form-control"
                                                   value="{{Input::old('mobile')}}" placeholder="Mobile Number"
                                                   maxlength="10">
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->
                            </fieldset>
                        </div>


                    </div>
                    <ul class="pager bwizard-buttons">

                        <li class="next">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </li>
                    </ul>
                </div>
                </form>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
    </div>

@stop

@section('page_specific_foot')
    <script src="<?php echo asset_path(); ?>/plugins/bootstrap-wizard/js/bwizard.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-wizards.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
@stop
