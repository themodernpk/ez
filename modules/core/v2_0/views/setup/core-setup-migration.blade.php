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
                    <span class="logo"></span> LV APP
                    <small>Application is licensed to <b>WebReinvent</b></small>

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
                {{ Form::open(array('route' => 'setupPost', 'role' => 'form')) }}
                <div class="bwizard clearfix" id="wizard">
                    <ol role="tablist" class="bwizard-steps clearfix clickable">
                        <li aria-selected="false" style="z-index: 3;" role="tab"><span
                                    class="label badge-inverse">1</span><a href="#step1" class="hidden-phone">
                                Database Configuration
                            </a><a href="#step1" class="hidden-phone">
                                <small>Make sure you have already create DB & it's credentials</small>
                            </a><a href="#step1" class="hidden-phone">
                            </a></li>
                        <li class="active" aria-selected="true" style="z-index: 4;" role="tab"><span
                                    class="label">2</span><a href="#" class="hidden-phone">
                                Run Migrations & Seeds
                            </a><a href="#step2" class="hidden-phone">
                                <small>It will create database schema & insert required data.</small>
                            </a><a href="#step2" class="hidden-phone">
                            </a></li>
                        <li aria-selected="false" style="z-index: 2;" role="tab"><span class="label">3</span><a
                                    href="#step3" class="hidden-phone">
                                Create Admin Account
                            </a><a href="#step3" class="hidden-phone">
                                <small>Final step is to create first admin account</small>
                            </a><a href="#step3" class="hidden-phone">
                            </a></li>

                    </ol>
                    <!-- begin wizard step-1 -->


                    <!-- end wizard step-4 -->
                    <div class="well">
                        <div aria-hidden="false" class="bwizard-activated" role="tabpanel" id="step1">
                            <fieldset>
                                <legend class="pull-left width-full">Click Below to Run Migrations & Seeds</legend>
                                <!-- begin row -->
                                <div class="row">

                                    <div class="text-center col-md-12">
                                        <a href="{{URL::route('migrationsAndSeedsRun')}}"
                                           class="btn btn-success btn-lg ajaxMigrations"><i class="fa fa-spinner"></i>
                                            Run Migrations</a>
                                    </div>

                                </div>
                                <!-- end row -->
                            </fieldset>
                        </div>


                    </div>


                </div>
                </form>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('.ajaxMigrations').click(function () {


                $(this).find('i').addClass('fa-spin');

                $.ajax({
                    type: "POST",
                    url: "<?php echo URL::route('migrationsAndSeedsRun'); ?>",
                    data: "ajax=true",
                    context: this,
                    success: function (msg) {

                        if (msg != "ok") {
                            alert(msg);
                        } else {
                            $(this).find('i').removeClass('fa-spin');
                            $(this).find('i').removeClass('fa-spinner');
                            $(this).find('i').addClass('fa-check');
                            window.location.replace("<?php URL::route('createAdmin'); ?>");
                        }

                    }
                });


                return false;

            });
        });
    </script>


@stop

@section('page_specific_foot')
    <script src="<?php echo asset_path(); ?>/plugins/bootstrap-wizard/js/bwizard.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-wizards.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
@stop