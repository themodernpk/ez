@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"/>

@stop



@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">

        <!-- begin col-10 -->
        <div class="col-md-12">


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                           data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                           data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                           data-click="panel-remove"><i class="fa fa-times"></i></a>

                    </div>
                    <h4 class="panel-title">Activity List</h4>
                </div>


                <div class="panel-body">


                    {{ Form::open(array('class' =>'form-inline', 'method' =>'GET')) }}

                    <div class="form-group pull-right">

                        <div class="input-group pull-left input-daterange">
                            <input type="text" class="form-control" name="start" value="<?php if (Input::has('start')) {
                                echo Input::get('start');
                            } ?>" placeholder="Date Start"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="form-control" name="end" value="<?php if (Input::has('end')) {
                                echo Input::get('end');
                            } ?>" placeholder="Date End"/>
                        </div>

                        <div class="btn-group " role="group">

                            <button type="submit" class="btn btn-success "><i class="fa fa-search"></i> Filter</button>
                            <a href="{{Request::url()}}" class="btn btn-warning"><i class="fa fa-search"></i> Reset</a>
                        </div>

                    </div>

                    {{Form::close()}}



                    {{ Form::open(array('route' => 'bulkAction', 'class' =>'form', 'method' =>'POST')) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <div class="btn-group">

                                </div>

                            </div>
                        </div>

                    </div>


                    <br/>

                    <div class="row">


                        <div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr class="filter_row">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Label</th>
                                    <th>Username</th>
                                    <th>Content</th>
                                    <th>Created</th>
                                </tr>

                                </thead>


                                <tbody>


                                @if(is_object($data['list']))
                                    @foreach($data['list'] as $item)

                                        <tr class="" id="{{$item->id}}">

                                            <td>{{$item->id}}</td>
                                            <td>{{ucfirst($item->name)}}</td>
                                            <td>{{$item->label}}</td>
                                            @if($item->user_id)
                                                <td>{{$item->user->name}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{$item->content}}</td>
                                            <td>{{Dates::showTimeAgo($item->created_at)}}</td>
                                        </tr>
                                    @endforeach
                                @endif


                                </tbody>


                            </table>
                        </div>
                    </div>

                    {{Form::hidden('table', get_table_name(), array('id' => 'table')) }}
                    {{Form::close()}}


                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-10 -->
    </div>
    <!-- end row -->




@stop

@section('page_specific_foot')

    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.js"></script>

    <script src="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>

    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.columnFilter.js"></script>

    <script src="<?php echo asset_path(); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script>
        $("#data-table").dataTable({"pageLength": 25}).columnFilter({
            sPlaceHolder: "head:after",
        });
    </script>



    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {

            $('.input-daterange').datepicker({
                todayBtn: "linked",
                format: 'yyyy-mm-dd'
            });

        });
    </script>





@stop