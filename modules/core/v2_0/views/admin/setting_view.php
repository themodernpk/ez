@extends('core::layout.backend')


@section('page_specific_head')
<link href="<?php echo asset_path(); ?>/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo asset_path(); ?>/plugins/pace/pace.min.js"></script>
@stop


@section('content')

<?php
//echo '<pre>'; print_r($data['list']); echo '</pre>';
$json_encode_value = $data['list']['list']->value;
$setting_id = $data['list']['list']->id;
$json_decode_value = json_decode($json_encode_value);
$host_name = $json_decode_value->host_name;
$port =  $json_decode_value->port;
$username =  $json_decode_value->username;
$password =  $json_decode_value->password;

?>

<!-- begin page-header -->
<h1 class="page-header">{{$title}}</h1>
<!-- end page-header -->

<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-validation-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">SMTP Settings</h4>
            </div>
            <div class="panel-body panel-form">
                <form class="form-horizontal form-bordered" data-parsley-validate="true" id="setting" name="demo-form">
                    <input type="hidden" name="setting_id" id="setting_id" value="<?php echo $setting_id;?>" />
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="hostname">Host Name * :</label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" id="host_name" name="host_name" value="<?php if(!empty($host_name)){ echo $host_name; } else {}?>" placeholder="Host Name" data-parsley-required="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="port">Port * :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="port" name="port" value="<?php if(!empty($port)){ echo $port; } else {}?>"  placeholder="Port" data-parsley-required="true" />
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="username">UserName * :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="username" name="username" value="<?php if(!empty($username)){ echo $username; } else {}?>" data-parsley-required="true" placeholder="UserName" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="password">Password * :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="password" id="password" name="password" value="<?php if(!empty($password)){ echo $password; } else {}?>" data-parsley-required="true" placeholder="Password" />
                            </div>
                        </div>

                    </div>

                    <input type="hidden" id='href' value="<?php echo URL::route('add_settings'); ?>">
                    <div lass="form-group">
                        <label class="control-label col-md-4 col-sm-4"></label>
                        <div class="col-md-6 col-sm-6">
                            <button type="submit" id="" class="btn btn-primary"><?php if(!empty($data)){ echo "Edit"; } else {echo "Submit";}?> </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- end panel -->
    </div>
    <!-- begin col-6 -->
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="ui-modal-notification-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">General Settings</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" data-parsley-validate="true" id="setting" name="demo-form">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SMTP Settings</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="active">
                            <td>
                                <div class="form-group">
                                    <label class="control-label col-md-4" for="hostname">Host Name * :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="host_name" name="host_name" value="<?php if(!empty($host_name)){ echo $host_name; } else {}?>" placeholder="Host Name" data-parsley-required="true" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="port">Port * :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="port" name="port" value="<?php if(!empty($port)){ echo $port; } else {}?>"  placeholder="Port" data-parsley-required="true" />
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr class="active">
                            <td>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="username">UserName * :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="username" name="username" value="<?php if(!empty($username)){ echo $username; } else {}?>" data-parsley-required="true" placeholder="UserName" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="password">Password * :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="password" id="password" name="password" value="<?php if(!empty($password)){ echo $password; } else {}?>" data-parsley-required="true" placeholder="Password" />
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <div lass="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" id="" class="btn btn-primary"><?php if(!empty($data)){ echo "Edit"; } else {echo "Submit";}?> </button>
                                </div>
                            </div>
                        </tr>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('page_specific_foot')
<script src="<?php echo asset_path(); ?>/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo asset_path(); ?>/setting.js"></script>

@stop