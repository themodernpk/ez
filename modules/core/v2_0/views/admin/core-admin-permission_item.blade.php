@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
    

@stop


@section('content')



    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">

        <!-- begin col-10 -->
        <div class="col-md-12">


            <!-- #modal-dialog -->
            <div class="modal fade" id="modal-dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form" id="demo-form" data-parsley-validate>
                      
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Details </h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                 <input type="text" class="form-control" placeholder="Permission Name" id="name" name="name" required >
                                 <input type="hidden" name="id">
                                
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                            <button type="button" id="permission_submit" data-href="<?php echo URL::route('permissionStore'); ?>"  class="btn btn-sm btn-success">Submit</button>
                        </div>
                        <!-- {{ Form::close() }} -->
                        </form>

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
                    <h4 class="panel-title">Permission List</h4>
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

                                @if(!empty($data['permissionlist']))
                                
                                    <td><?php echo $data['permissionlist']->id;?></td>
                                    <td><?php echo $data['permissionlist']->name;?></td>
                                    <td><?php echo $data['permissionlist']->slug;?></td>
                                    
                                    <td>{{Dates::showTimeAgo($data['permissionlist']->created_at)}}</td>
                                    <td>{{Dates::showTimeAgo($data['permissionlist']->updated_at)}}</td>
                               
                                    
                                  
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

  
    <script src="<?php echo asset_path(); ?>/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/dataTables.colVis.js"></script>

    <script src="<?php echo asset_path(); ?>/js/table-manage-colvis.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-slider-switcher.demo.min.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
    <script src="<?php echo asset_path(); ?>/permission.js"></script>
    <script src="<?php echo asset_path(); ?>/common.js"></script>



    <script>
       $(document).ready(function () {
            TableManageColVis.init();
            FormSliderSwitcher.init();


            $('#selectall').click(function () {

                var current_state = $(this).is(":checked");

                if (current_state == true) {
                    $(".idCheckbox").each(function () {
                        $(this).attr("checked", true);
                    });
                } else {
                    $(".idCheckbox").each(function () {
                        $(this).attr("checked", false);
                    });
                }


            });


        }); 
    </script>

    <!-- {{ View::make('core::layout.javascript')->with('block_name', 'row_edit'); }} -->
    


@stop