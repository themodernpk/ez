@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
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
                <th>Name</th>
                <th>Slug</th>
                <th width="30"></th>
                @if(Permission::check($data->prefix.'-update'))
                    <th width="80">Enable</th>
                    <th width="120">Actions</th>
                    <th width="20"><input id="selectall" type="checkbox"/></th>
                @endif
            </tr>
            @foreach($data->list as $item)
                {{View::make($data->view.'elements.index-item')->with('item', $item)->with('data', $data)->render()}}
            @endforeach
        </table>
        <?php
        $get = Input::get();
        echo $data->list->appends($get)->links();
        ?>
    </div>


    {{Form::close()}}

    {{HtmlHelper::panelClose()}}


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
        $(document).ready(function () {
            FormSliderSwitcher.init();
        });
    </script>
    <script src="<?php echo asset_path('crud'); ?>/crud.js"></script>
@stop