@extends('core::layout.backend')

@section('page_specific_head')
@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}} @if(isset($data->input->show)) - {{ucwords($data->input->show)}} @endif</h1>
    <!-- end page-header -->

    <!--content-->
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {{HtmlHelper::panel(array('title' => "Your Account Details"))}}
            <div class="pull-right m-b-10">
                <a href="#ModalUpdateForm" data-toggle="modal" class="btn btn-primary">Update Account</a>
            </div>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="150">Name</th>
                    <td>{{$data['user']->name}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$data['user']->email}}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{$data['user']->mobile}}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><p class="text-warning">To reset your password, update your account</p></td>
                </tr>
            </table>
            {{HtmlHelper::panelClose()}}
        </div>
    </div>
    <!--/content-->


    <!--modal-->
    <!--modal-->
    {{HtmlHelper::modal(array('title' => "Update your account", 'modal_id'=>"ModalUpdateForm", 'class' => 'modal-dialog-sm'))}}
    {{ Form::open(array('class' =>'form form-horizontal',
    'route' => 'updateAccount', 'id'=>'updateFrom', 'method' =>'POST', 'data-parsley-validate')) }}
    <!--modal body-->
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-md-3 control-label">Name:</label>
                    <div class="col-md-9">
                        {{ Form::text('name', $data['user']->name, array('class' => 'form-control ',
                        'placeholder' => 'Name', 'required')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Email:</label>
                    <div class="col-md-9">
                        {{ Form::text('email', $data['user']->email, array('class' => 'form-control ',
                        'placeholder' => 'Email Address', 'required')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile:</label>
                    <div class="col-md-9">
                        {{ Form::text('mobile', $data['user']->mobile, array('class' => 'form-control ',
                        'placeholder' => 'Mobile Number', 'required', 'maxlength'=>10)) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">New Password</label>
                    <div class="col-md-9">
                        <input type="password" placeholder="New Password" class="form-control" name="password">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/modal body-->
    <br clear="all"/>
    <div class="modal-footer">
        <button type="submit"
                class="btn btn-sm btn-success loader"><i class="fa fa-save"></i> Submit
        </button>
    </div>
    {{Form::hidden('format', 'json')}}
    {{ Form::close() }}

    {{HtmlHelper::modalClose()}}
    <!--/modal-->

    <!--/modal-->


@stop

@section('page_specific_foot')

    <script src="<?php echo asset_path('core'); ?>/account.js"></script>
@stop