@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
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
                        {{ Form::open(array( 'method' =>'POST', 'id' => 'addNew','data-parsley-validate'=>'true')) }}

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Add New User</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name','id'=>'name', 'data-parsley-required'=>'true')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::text('email', null, array('class' => 'form-control email', 'placeholder' => 'Email', 'id'=>'email','data-parsley-type'=>'email','data-parsley-required'=>'true')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Pasword','id'=>'password','data-parsley-required'=>'true')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::text('mobile', null, array('class' => 'form-control', 'placeholder' => 'Mobile','id'=>'mobile', 'data-parsley-type'=>'digits')) }}
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="group_id" name="group_id" required>
                                    <option value="" selected disabled>Please Select Group</option>
                                    @foreach($data['group'] as $item)
                                        <option value="{{$item->id}}"><?php echo $item->name; ?></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-4">Choose Status:</label>

                                <div class="radio">
                                    <label class="col-md-2">
                                        <input type="radio" name="active" value="1" id="radio-required"
                                               data-parsley-required="true"/> Active
                                    </label>


                                    <label>
                                        <input type="radio" name="active" id="radio-required2" value="0"/> Deactivate
                                    </label>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id='href' value="<?php echo URL::route('userStore'); ?>">
                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" id="add_user" class="btn btn-sm btn-success">Submit</button>
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>


            <!-- #end of modal-dialog -->

            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{ Form::open(array('method' =>'POST','id'=>'editform','data-parsley-validate'=>'true')) }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalLabel"><i class="fa"></i> Edit User </h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id" value="">

                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Name:</label>
                                <input type="text" class="form-control" name="name" id="user_name" value="Edit Name" data-parsley-required='true'>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Email:</label>
                                <input type="text" class="form-control" name="email" id="user_email" value="Edit Email" data-parsley-type="email" data-parsley-required="true" >
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Phone:</label>
                                <input type="text" class="form-control" name="mobile" id="user_mobile" value="Edit Phone" data-parsley-type="digits">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Group:</label>

                                <select class="form-control" id="user_group_id" name="group_id" >
                                    <option>Select Group</option>
                                    @foreach($data['group'] as $item)
                                        <option value="{{$item->id}}"><?php echo $item->name; ?></option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id='edithref' value="<?php echo URL::route('userStore'); ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="update" class="btn btn-primary">Update</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>


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
                    <h4 class="panel-title">User List</h4>
                </div>


                <div class="panel-body">

                    {{ Form::open(array('route' => 'bulkAction', 'class' =>'form', 'method' =>'POST')) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <div class="btn-group">

                                    @if(!Input::has('trash'))

                                        @if(Permission::check('allow-to-add-user'))
                                            <a class="btn btn-sm btn-info" href="#modal-dialog" data-toggle="modal"><i
                                                        class="fa fa-plus"></i> Add</a>
                                        @endif
                                        @if(Permission::check('allow-bulk-active'))
                                            <button type="submit" name="action" value="active"
                                                    class="btn btn-sm btn-success"><i class="fa fa-check"></i> Activate
                                            </button>
                                        @endif

                                        @if(Permission::check('allow-bulk-deactive'))
                                            <button type="submit" name="action" value="deactive"
                                                    class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> Deactive
                                            </button>
                                        @endif

                                        @if(Permission::check('allow-bulk-delete'))
                                            <button type="submit" name="action" value="delete"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete
                                            </button>
                                        @endif

                                        @if(Permission::check('allow-to-view-trash'))
                                            <a href="{{URL::full().'?trash=1' }}" class="btn btn-sm btn-inverse"><i
                                                        class="fa fa-trash-o"></i> Trash (<?php echo $data['count'];?>)</a>
                                        @endif

                                    @else



                                        <a class="btn btn-sm btn-info" href="{{URL::route('users')}}"><i
                                                    class="fa fa-angle-double-left"></i> Back</a>
                                        @if(Permission::check('allow-permanent-delete'))
                                            <button type="submit" name="action" value="forcedelete"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Permanent
                                                Delete
                                            </button>
                                        @endif

                                        @if(Permission::check('allow-to-restore'))
                                            <button type="submit" name="action" value="restore"
                                                    class="btn btn-sm btn-success"><i class="fa fa-share-square-o"></i>
                                                Restore
                                            </button>
                                        @endif
                                    @endif
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
                                    <th>Email / Mobile</th>
                                    <th>Group</th>
                                    <th width="110">Last Login</th>
                                    @if(Permission::check('allow-activedeactive'))
                                        <th>Active</th>
                                    @endif
                                    <th>Created / Updated</th>
                                    @if(!Input::has('trash'))
                                        <th>Actions</th>
                                    @endif
                                    <th><input id="selectall" type="checkbox"/></th>
                                </tr>
                                </thead>

                                <tbody>


                                @if(is_object($data['list']))
                                    @foreach($data['list'] as $item)


                                        <tr class="" id="{{$item->id}}">

                                            <td>{{$item->id}}</td>
                                            <td>
                                                @if(!Input::has('trash') && Permission::check('allow-ajax-edit'))

                                                    <a class="editable" data-pk="{{$item->id}}"
                                                       data-name="{{get_table_name()}}" id="edit-{{$item->id}}"
                                                       href="#">{{$item->name}}</a>
                                                @else
                                                    {{$item->name}}
                                                @endif
                                            </td>
                                            <td class="email">{{$item->email}}
                                            @if($item->mobile)
                                                   <br/> {{$item->mobile}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->group->name)
                                                {{$item->group->name}}
                                                    @else
                                                NA
                                                    @endif
                                            </td>
                                            <td>{{Dates::dateformat($item->lastlogin)}}</td>

                                            @if(Permission::check('allow-activedeactive'))
                                                <td>
                                                    <?php $exception = false;

                                                    if (in_array($item->id, core_settings('users')['exceptions'])) {
                                                        $exception = true;
                                                    }

                                                    ?>

                                                        @if($item->active == 1)

                                                            <input type="checkbox" data-render="switchery" class="BSswitch"
                                                                   data-theme="green" checked="checked" data-switchery="true"
                                                                   data-pk="{{$item->id}}"
                                                                   data-href="{{URL::route('ajax_update_col')}}?name=users|active"
                                                                   style="display: none;">
                                                        @else

                                                            <input type="checkbox" data-render="switchery" class="BSswitch"
                                                                   data-theme="green"  data-switchery="true"
                                                                   data-pk="{{$item->id}}"
                                                                   data-href="{{URL::route('ajax_update_col')}}?name=users|active"
                                                                   style="display: none;">

                                                        @endif
                                                </td>
                                            @endif

                                            <td>{{Dates::showTimeAgo($item->created_at)}}
                                                @if($item->updated_at)
                                                    <br/> / {{Dates::showTimeAgo($item->updated_at)}}
                                                @endif
                                            </td>
                                            @if(!Input::has('trash'))
                                                <td>
                                                    @if(Permission::check('allow-to-edit-user'))

                                                        <span data-toggle="tooltip" data-placement="top"
                                                              data-original-title="Edit User">
                                            <a id="user_edit" class="btn btn-sm btn-icon btn-circle btn-info"
                                               data-toggle="modal" data-target="#edit" data-whatever="{{$item->id}}"><i
                                                        class="fa fa-edit"></i></a>
                                           </span>
                                                    @endif
                                                    @if(Permission::check('allow-soft-delete'))
                                                        <a class="btn btn-sm btn-icon btn-circle btn-danger"
                                                           id="delete_{{$item->id}}" data-exception="{{$exception}}"
                                                           data-toggle="tooltip" data-placement="top"
                                                           data-href="<?php echo URL::route('ajax_delete'); ?>"
                                                           data-original-title="Delete" title=""><i
                                                                    class="fa fa-minus"></i></a>
                                                    @endif
                                                </td>
                                            @endif

                                            <td><input type="checkbox" class="idCheckbox" name="id[]"
                                                       value="{{$item->id}}">
                                                @if(Permission::check('allow-permanent-delete'))
                                                    @if(Input::has('trash'))
                                                        <input type="hidden" name="selctedname[]"
                                                               value="{{$item->name}}">
                                                    @endif
                                                @endif
                                            </td>


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

    @include('core::elements.datatable-switchery')

    <script src="<?php echo asset_path(); ?>/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="<?php echo asset_path(); ?>/user.js"></script>

    {{ View::make('core::layout.javascript')->with('block_name', 'row_edit'); }}

    <script>
        $(document).ready(function () {

            $('#user_edit').tooltip();

        });




        $(document).ready(function () {
            $('#edit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('whatever');
                var table = $('#table').val();

                $(this).find('i').addClass('fa-spin');
                $(this).find('i').addClass('fa-spinner');

                $.ajax({
                    type: "POST",
                    url: "<?php echo URL::route('ajax_model_box'); ?>",
                    context: this,
                    data: 'id=' + id + '&table=' + table,
                    success: function (response) {

                        var object = JSON.parse(response);
                        $(".modal-header #ModalLabel").find('i').removeClass('fa-spin');
                        $(".modal-header #ModalLabel").find('i').removeClass('fa-spinner');

                        //alert(response);
                        $(".modal-body #id").val(object.data.id);
                        $(".modal-body #user_name").val(object.data.name);
                        $(".modal-body #user_email").val(object.data.email);
                        $(".modal-body #user_mobile").val(object.data.mobile);
                        $(".modal-body #user_group_id").val(object.data.group_id);

                    },
                    error: function () {
                        alert("failure");
                    }
                });


            });



        });




    </script>


@stop