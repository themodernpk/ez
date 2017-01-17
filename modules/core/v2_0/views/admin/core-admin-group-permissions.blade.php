@extends('core::layout.backend')
@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
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
                    <h4 class="panel-title">Permissions List</h4>
                </div>

                <div class="panel-body">

                    <!--  form for activate/Deactivte delete/thrash   -->
                    {{ Form::open(array('route' => 'bulkAction', 'class' =>'form', 'method' =>'POST')) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <div class="btn-group">

                                    <!-- if group has no thrashed -->
                                    <!--  @if(!Input::has('trash'))
                                        <a class="btn btn-sm btn-info" href="#modal-dialog" data-toggle="modal"><i class="fa fa-plus"></i> Add</a>
                                        <button type="submit" name="action" value="active" class="btn btn-sm btn-success" ><i class="fa fa-check"></i> Activate</button>
                                        <button type="submit" name="action" value="deactive" class="btn btn-sm btn-warning" ><i class="fa fa-minus"></i> Deactive</button>
                                        <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" ><i class="fa fa-times"></i> Delete</button>
                                        @else

                                            <a  class="btn btn-sm btn-info" href="{{URL::route('groups')}}" ><i class="fa fa-angle-double-left"></i> Back</a>
                                        <button type="submit" name="action" value="forcedelete" class="btn btn-sm btn-danger" ><i class="fa fa-times"></i> Permanent Delete</button>
                                        <button type="submit" name="action" value="restore" class="btn btn-sm btn-inverse"><i class="fa fa-trash-o"></i> Restore</button>
                                    @endif -->
                                </div>

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
                                    <th>Active</th>
                                    <!-- <th>Actions</th>
                                    <th><input id="selectall" type="checkbox"/></th>-->
                                </tr>
                                </thead>

                                <tbody>


                                <!-- get the all group and list them -->
                                @if(is_object($data['list']))
                                    @foreach($data['list'] as $item)

                                        <tr class="" id="{{$item->pivot->id}}">

                                            <td>{{$item->pivot->id}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->slug}}</td>
                                            <td>
                                                <?php $exception = false; ?>
                                                <!-- check status id from group permission table -->


                                                @if($item->pivot->active == 1)

                                                    <input type="checkbox" data-render="switchery" class="BSswitch"
                                                           data-theme="green" checked="checked" data-switchery="true"
                                                           data-pk="{{$item->pivot->id}}"
                                                           data-href="{{URL::route('ajax_update_col')}}?name=group_permission|active"
                                                           style="display: none;">
                                                @else

                                                    <input type="checkbox" data-render="switchery" class="BSswitch"
                                                           data-theme="green"  data-switchery="true"
                                                           data-pk="{{$item->pivot->id}}"
                                                           data-href="{{URL::route('ajax_update_col')}}?name=group_permission|active"
                                                           style="display: none;">
                                                @endif

                                            </td>


                                        </tr>
                                    @endforeach
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
                    {{Form::hidden('table', get_table_name(NULL, 'group_permission'), array('id' => 'table')) }}
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

    @include('core::elements.datatable-switchery')

    <script src="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script>
        $(document).ready(function () {


            $('.idCheckbox').click(function () {
                if (!$(this).is(":checked")) {
                    $('#selectall').attr("checked", false);
                }
            });
        });
    </script>
@stop