<!--modal-->
{{HtmlHelper::modal(array('title' => "Fill Details", 'modal_id'=>"ModalCreateForm", 'class' => 'modal-dialog-sm'))}}
{{ Form::open(array('class' =>'form form-horizontal',
'route' => $data->prefix.'-create', 'id'=> 'createFrom' ,'method' =>'POST', 'data-parsley-validate')) }}
<!--modal body-->
<div class="modal-body">

@include($data->settings->view.'elements.form');

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
