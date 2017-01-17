<div class="col-md-8 col-sm-12 m-b-5">

    <div class="pull-right">

    @if(!isset($data->input->show))
        <div class="btn-group">

            @if(Permission::check($data->prefix.'-update'))

            <button type="submit" name="action" value="enable"
                    class="btn btn-sm btn-success"><i class="fa fa-thumbs-up"></i> Enable
            </button>


            <button type="submit" name="action" value="disable"
                    class="btn btn-sm btn-warning"><i class="fa fa-thumbs-down"></i> Disable
            </button>
                @endif

                @if(Permission::check($data->prefix.'-delete'))
            <button type="submit" name="action" value="delete"
                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete
            </button>
                @endif


        </div>
    @endif

    <div class="btn-group">

        @if(isset($data->input->show))
            <a href="{{Request::url()}}" class="btn btn-sm btn-info ">
                <i class="fa fa-arrow-circle-left"></i> Back
            </a>
        @endif

            @if(Permission::check($data->prefix.'-delete'))
        <a href="{{Request::url()}}?show=trash" class="btn btn-sm btn-inverse ">
            <i class="fa fa-trash"></i> Trash @if(isset($data->trash_count)) ({{$data->trash_count}}) @endif
        </a>
            @endif
    </div>

    @if(isset($data->input->show) && $data->input->show == 'trash')
        <div class="btn-group">
            @if(Permission::check($data->prefix.'-delete'))
            <button type="submit" name="action" value="restore"
                    class="btn btn-sm btn-success"><i class="fa fa-share-square-o"></i>
                Restore
            </button>

            <button type="submit" name="action" value="permanent_delete"
                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Permanent
                Delete
            </button>
            @endif

        </div>
    @endif

    </div>

</div>