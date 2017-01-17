<!--modal-->
{{HtmlHelper::modal(array('title' => "Fill Details", 'modal_id'=>"ModalCreateForm", 'class' => 'modal-dialog-sm'))}}
{{ Form::open(array('class' =>'form form-horizontal',
'route' => $data->prefix.'-create', 'id'=> 'createFrom' ,'method' =>'POST', 'data-parsley-validate')) }}
<!--modal body-->
<div class="modal-body">

    <div class="row">

        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Name:</label>
                <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control ',
                    'placeholder' => 'Name', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label">Choose Status:</label>

                <div class="col-md-9 col-sm-8">
                    <div class="radio">
                        <label>
                            <input type="radio" name="active" value="1" data-parsley-required>
                            Active
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="active" value="0" data-parsley-required >
                            Deactive
                        </label>
                    </div>
                </div>

        </div>

        </div>


    </div>
</div>
<!--/modal body-->
<br clear="all"/>
<div class="modal-footer">
    <button type="submit"
            class="btn btn-sm btn-success loader"><i class="fa fa-save"></i> Submit
    </button>

</div>
{{Form::hidden('format', 'json')}}
{{ Form::close() }}

{{HtmlHelper::modalClose()}}
<!--/modal-->
