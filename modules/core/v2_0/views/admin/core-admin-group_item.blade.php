@extends('core::layout.backend')
@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
@stop

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">

        <!-- begin col-10 -->
        <div class="col-md-12">


            <!-- open model when click on add button -->
            <!-- #modal-dialog -->
            <div class="modal fade" id="modal-dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{ Form::open(array('class' =>'form','id'=>'form' ,'method' =>'POST')) }}

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Details</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                {{ Form::text('name', null, array('class' => 'form-control ', 'placeholder' => 'Group Name', 'id' =>'group_name', 'required')) }}
                            </div>

                        </div>
                        <div class="modal-footer">

                            <a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                            <button type="button" id="group_submit" data-href="<?php echo URL::route('groupStore'); ?>" class="btn btn-sm btn-success loader"><i class="fa fa-edit"></i>
                                Submit
                            </button>
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
            <!-- #end of modal-dialog -->

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
                    <h4 class="panel-title">Group List</h4>
                </div>

                <div class="panel-body">

                    {{ Form::open(array('route' => 'bulkAction', 'class' =>'form', 'method' =>'POST')) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                

                            </div>
                        </div>

                    </div>

                    <br/>

                    <div class="row">

                        <div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>                                 
                                    <th>Created</th>
                                    <th>Updated</th>
                                   
                                </tr>
                                </thead>

                                <tbody>
                                     @if(!empty($data['list']))
                                       <td><?php echo $data['list']->id;?></td>
                                       <td><?php echo $data['list']->name;?></td>
                                       <td><?php echo $data['list']->slug;?></td>
                                       <td>{{Dates::showTimeAgo($data['list']->created_at)}}</td>
                                        <td>{{Dates::showTimeAgo($data['list']->updated_at)}}</td>
                                      @endif                             

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- hidden field to send table name
                       // ist argument is hidden field name which is table
                       // used to send data to server side
                       // through name attribue we get value of this field which is table name
                       // 2nd argument is value which is actually table name in encrypted form
                       // 3rd argument is id to perfrorm client side operation  ,like ajax to switch status
                     -->
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

    <script src="<?php echo asset_path(); ?>/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/dataTables.colVis.js"></script>

    <script src="<?php echo asset_path(); ?>/js/table-manage-colvis.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-slider-switcher.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
    <script src="<?php echo asset_path(); ?>/group.js"></script>
    <script src="<?php echo asset_path(); ?>/common.js"></script>



    <script>
        $(document).ready(function () {
            TableManageColVis.init();
            FormSliderSwitcher.init();

            // select all check box if it is checked

            $('#selectall').click(function () {
                var current_state = $(this).is(":checked");

                if (current_state) {
                    $(".idCheckbox").each(function () {
                        $(this).attr("checked", true);
                    });
                } else {
                    $(".idCheckbox").each(function () {
                        $(this).attr("checked", false);
                    });
                }

            });

            // DeActivate the parent if parent is not selected
            $('.idCheckbox').click(function () {
                if (!$(this).is(":checked")) {
                    $('#selectall').attr("checked", false);
                }
            });
        });

    </script>


   <!--  {{ View::make('core::layout.javascript')->with('block_name', 'row_edit'); }} -->


@stop
