@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />

    <!--data table-->
    <link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
    <!--/data table-->

@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}} @if(isset($data->input->show)) - {{ucwords($data->input->show)}} @endif</h1>
    <!-- end page-header -->

    <!--modal-->
    @include($data->view."elements.create")
    @include($data->view."elements.view")
    @include($data->view."elements.update")
    <!--/modal-->

    <!--content-->
        {{HtmlHelper::panel(array('title' => "List"))}}

    {{ Form::open(array('route' => $data->prefix.'-bulk-action', 'class' =>'form mainform', 'method' =>'POST')) }}
        <div class="row">
        @include($data->view."service")

        @include($data->view."elements.buttons")
        </div>

        <hr/>
        <div class="row">

        <table id="data-table" class="table table-bordered table-striped data-table table-responsive">
            <thead>
            <tr>
                <th width="20">#</th>
                <th>Name / Email / Mobile</th>
                <th>Group</th>
                <th>Last Login</th>
                <th width="30"></th>
                @if(Permission::check($data->prefix.'-update'))
                    @if(!isset($data->input->show))
                    <th width="80">Enable</th>
                    <th width="120">Actions</th>
                    @endif
                    <th width="20"><input id="selectall" type="checkbox"/></th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach($data->list as $item)
            <tr class="@if(!is_null($item->deleted_at)) danger @endif" >
                <td>{{$item->id}}</td>
                <td>{{$item->name}} / {{$item->email}} / {{$item->mobile}} </td>
                <td>
                    @if($item->group)
                    {{$item->group->name}}
                    @else
                        <span class="text-danger">No Group Assigned</span>
                    @endif
                </td>
                <td>{{Dates::dateformat($item->lastlogin)}}</td>
                <td>
                    <span data-toggle="tooltip" data-placement="top" data-original-title="View">
                        <a class="btn btn-sm btn-icon btn-circle btn-info viewItem"
                           data-toggle="modal"
                           data-pk="{{$item->id}}"
                           data-href="{{URL::route($data->prefix.'-read',
                           array('id' => $item->id, 'format' => 'json'))}}"
                           data-target="#ModalView" >
                            <i class="fa fa-eye"></i>
                        </a>
                       </span>
                </td>

                @if(Permission::check($data->prefix.'-update'))
                    @if(!isset($data->input->show))
                    <td>

                        @if($item->active == 1)

                            <input type="checkbox" data-render="switchery" class="BSswitch"
                                   data-theme="green" checked="checked" data-switchery="true"
                                   data-pk="{{$item->id}}"
                                   data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=disable&format=json"
                                   style="display: none;">
                        @else

                            <input type="checkbox" data-render="switchery" class="BSswitch"
                                   data-theme="green"  data-switchery="true"
                                   data-pk="{{$item->id}}"
                                   data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=enable&format=json"
                                   style="display: none;">

                        @endif

                    </td>

                    <td>
                        @if(Permission::check($data->prefix.'-update'))
                            <span data-toggle="tooltip" data-placement="top" data-original-title="Update">
                                            <a class="btn btn-sm btn-icon btn-circle btn-info updateItem"
                                               data-toggle="modal"
                                               data-pk="{{$item->id}}"
                                               data-href="{{URL::route($data->prefix.'-read',
                                               array('id' => $item->id, 'format' => 'json'))}}"
                                               data-target="#ModalUpdate" >
                                                <i class="fa fa-edit"></i>
                                            </a>
                            </span>


                            @endif

                            @if(Permission::check($data->prefix.'-delete'))
                                <span data-toggle="tooltip" data-placement="top" data-original-title="Delete">
                                            <a class="btn btn-sm btn-icon btn-circle btn-danger ajaxDelete"
                                               data-pk="{{$item->id}}"
                                               data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=delete&format=json">
                                                <i class="fa fa-times"></i>
                                            </a>
                                           </span>
                            @endif

                    </td>
                    @endif

                    <td><input class="idCheckbox" type="checkbox" name="id[]" value="{{$item->id}}" /></td>
                @endif
            </tr>
                @endforeach

            </tbody>

        </table>


            <br class="clearfix"/><br/>
            <hr/>
            <?php
            $get = Input::get();
            echo $data->list->appends($get)->links();
            ?>


        </div>


        {{Form::close()}}

        {{HtmlHelper::modalClose()}}


    <!--/content-->


@stop

@section('page_specific_foot')
    <!--highlight search-->
    @if(isset($data->input->q))
        <script>
            $("body").highlight("{{$data->input->q}}");
        </script>
    @endif
    <!--highlight search-->

    <script src="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-slider-switcher.demo.min.js"></script>

        <!--data table-->
        <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.js"></script>
        <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/dataTables.responsive.js"></script>
        <script src="<?php echo asset_path(); ?>/js/table-manage-responsive.demo.min.js"></script>
        <script>
            $(document).ready(function ()
            {
                FormSliderSwitcher.init();

                $("#data-table").DataTable({ "autoWidth": false,
                    pageLength:100,
                    "order": [[ 0, "desc" ]],
                    "bPaginate": false,
                });

                $(".paginate_button").click(function()
                {
                    FormSliderSwitcher.init();
                });

            });
        </script>
        <!--/data table-->


        <script src="<?php echo asset_path(); ?>/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
        <script>
            $('document').ready(function()
            {
                $(".combobox").combobox();
            });
        </script>

    <script src="<?php echo asset_path('core'); ?>/user.js"></script>
@stop