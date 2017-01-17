<!--modal-->
{{HtmlHelper::modal(array('title' => "Update Details", 'modal_id'=>"ModalUpdate"))}}

{{ Form::open(array('class' =>'form form-horizontal', 'route' => $data->prefix.'-update',
'id'=>'formUpdate' ,'method' =>'POST', 'data-parsley-validate')) }}
<!--modal body-->
<div class="modal-body">
@include($data->settings->view.'elements.form');
</div>
<!--/modal body-->
<br clear="all"/>
<div class="modal-footer">

    <button type="submit" id="group_submit"
            class="btn btn-sm btn-success loader"><i class="fa fa-save"></i> Submit
    </button>

</div>
{{Form::hidden('format', 'json')}}
{{Form::hidden('id')}}
{{ Form::close() }}


{{HtmlHelper::modalClose()}}
<!--/modal-->
