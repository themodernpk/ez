@extends('core::layout.backend')

@section('page_specific_head')
        <!--data table-->
<link href="<?php echo asset_path(); ?>/plugins/DataTables/css/data-table.css" rel="stylesheet"/>
<!--/data table-->
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}} @if(isset($data->input->show)) - {{ucwords($data->input->show)}} @endif</h1>
    <!-- end page-header -->



    <!--content-->
        {{HtmlHelper::panel(array('title' => "Permission List"))}}

        <div class="row">
            <div class="pull-right">
            <a href="{{URL::route('core-group-index')}}" class="btn btn-inverse btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <hr/>
        <div class="row">

            <table id="data-table" class="table table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>

                @foreach($data->item->permissions as $permission)

                    <tr>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->slug}}</td>
                        <td>
                            @if($permission->pivot->active == 1)
                                    <input type="checkbox" data-render="switchery" class="BSswitch"
                                           data-theme="green" checked="checked" data-switchery="true"
                                           data-pk="{{$permission->pivot->id}}"
                                           data-href="{{URL::route('ajax_update_col')}}?name=group_permission|active"
                                           style="display: none;">
                                @else

                                    <input type="checkbox" data-render="switchery" class="BSswitch"
                                           data-theme="green"  data-switchery="true"
                                           data-pk="{{$permission->pivot->id}}"
                                           data-href="{{URL::route('ajax_update_col')}}?name=group_permission|active"
                                           style="display: none;">
                                @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>



        {{HtmlHelper::modalClose()}}


    <!--/content-->


@stop

@section('page_specific_foot')
    <script src="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-slider-switcher.demo.min.js"></script>

    <!--data table-->
    <script src="<?php echo asset_path(); ?>/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function ()
        {
            FormSliderSwitcher.init();

            $("#data-table").DataTable({"aLengthMenu": [ [-1], ["All"] ], pageLength:0, "order": [[ 0, "desc" ]]});

            $(".paginate_button").click(function()
            {
                FormSliderSwitcher.init();
            });

        });
    </script>
    <!--/data table-->


    <script src="<?php echo asset_path('core'); ?>/group.js"></script>
@stop