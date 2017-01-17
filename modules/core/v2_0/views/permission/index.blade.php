@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}} @if(isset($data->input->show)) - {{ucwords($data->input->show)}} @endif</h1>
    <!-- end page-header -->

    <!--modal-->
    @include($data->view."elements.view")
    @include($data->view."elements.update")
    <!--/modal-->

    <!--content-->
        {{HtmlHelper::panel(array('title' => "List"))}}
        {{ Form::open(array('route' => $data->prefix.'-bulk-action', 'class' =>'form', 'method' =>'POST')) }}
        <div class="row">
        @include($data->view."elements.search")
        @include($data->view."elements.buttons")
        </div>

        <hr/>
        <div class="row">
        <table class="table table-bordered table-striped">
            <tr>
                <th width="20">#</th>
                <th>Name - (Groups) (Users)</th>
                <th>Slug</th>
                <th width="30"></th>
                @if(Permission::check($data->prefix.'-update'))
                    <th width="80">Enable</th>
                    <th width="80">Actions</th>
                    <th width="20"><input id="selectall" type="checkbox"/></th>
                @endif
            </tr>

            @foreach($data->list as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}} -
                    ({{$item->groups(1)->count()}})
                    ({{count(Permission::users_have_permission($item->slug))}})
                </td>
                <td>{{$item->slug}}</td>
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


                    <td><input class="idCheckbox" type="checkbox" name="id[]" value="{{$item->id}}" /></td>
                @endif
            </tr>
                @endforeach

        </table>
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
    <script>
        $(document).ready(function ()
        {
            FormSliderSwitcher.init();
        });
    </script>
    <script src="<?php echo asset_path('core'); ?>/permission.js"></script>
@stop