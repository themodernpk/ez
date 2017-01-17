@extends('core::layout.backend')


@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/parsley/src/parsley.css" rel="stylesheet" />

@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <div class="row">
        <!-- begin col-12 -->
        <form  id="create_setting" data-parsley-validate="true" name="demo-form">
        <div class="col-12">
            <!-- begin panel -->

            <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
                <div class="panel-heading">
                  <!-- <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>-->
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" name="add" value="add"
                                    class="btn btn-sm btn-success"  onclick="addRow('dataTable')"><i class="fa fa-plus"></i> Add Row
                            </button>
                            <button type="button" name="delete" value="delete"
                                    class="btn btn-sm btn-danger" onclick="deleteRow('dataTable')"><i class="fa fa-minus"></i> Delete Row
                            </button>
                            <button type="submit" name="save" value="save"
                                    class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save
                            </button>

                        </div>
                    </div>

                    <h4 class="panel-title">Create Settings</h4>
                </div>
                <div class="panel-body">

                    <input type="hidden" name="general_href"  id="href" value="<?php echo URL::route('settingStore');?>"/>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="info">
                                <td>#</td>
                                <td>Key</td>
                                <td>Group</td>
                                <td>Label</td>
                                <td>Value</td>

                            </tr>
                        </thead>

                        <tbody  id="dataTable">
                            <tr>
                                <td><input type="checkbox" name="" ></td>
                                <td><input type="text" name="0[key]" class="form-control" required="" ></td>
                                <td><input type="text" name="0[group]" class="form-control" data-parsley-required="true"></td>
                                <td><input type="text" name="0[label]" class="form-control" data-parsley-required="true"></td>
                                <td><input type="text" name="0[value]" class="form-control" data-parsley-required="true"></td>
                            </tr>
                        </tbody>
                    </table>



            </div>
            <!-- end panel -->
        </div>

        <!-- end col-6 -->
        </div>
        </form>

        <div class="row">

            <?php $setting_groups = Setting::select('group')->groupBy('group')->get(); ?>
            @foreach($setting_groups as $group)
                <div class="col-md-6">
                    {{HtmlHelper::panel(array('title' => ucwords($group->group)))}}

                    <form action="{{URL::route('setting-update')}}" method="post" data-parsley-validate="true">

                        <fieldset>

                            <?php $settings = Setting::where('group', '=', $group->group)->get(); ?>
                            @foreach($settings as $item)

                                <div class="form-group">
                                    <label>{{$item->label}} <span class="text-info">[Key : {{$item->key}}]</span></label>
                                    <input type="text" class="form-control" name="{{$item->key}}" value="{{$item->value}}" />
                                </div>
                                <hr>
                            @endforeach

                            <button type="submit" class="btn btn-primary m-r-5">Save</button>

                        </fieldset>

                    </form>


                    {{HtmlHelper::panelClose()}}

                </div>
                @endforeach

        </div>
    </div>


@stop

@section('page_specific_foot')

    <script src="<?php echo asset_path(); ?>/plugins/parsley/dist/parsley.js"></script>
    <script src="<?php echo asset_path(); ?>/setting.js"></script>




@stop