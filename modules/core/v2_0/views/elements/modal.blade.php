@if(isset($data['start']))
<!-- #modal-dialog -->
<div class="modal fade" id="{{$data['modal_id']}}">
    <div class="modal-dialog @if(isset($data['class'])) {{$data['class']}} @else modal-dialog-large @endif">
        <div class="modal-content ">
            <div class="modal-header">

                <div class="pull-right">
                    <button class="btn btn-icon btn-circle btn-warning modalLoader" style="display: none;">
                        <i class="fa fa-spin fa-spinner"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-circle btn-danger"
                            data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                    </button>

                </div>
                @if(isset($data['title']))
                <h4 class="modal-title">{{$data['title']}}</h4>
                    @endif
            </div>
@endif
@if(isset($data['end']))
        </div>
    </div>
</div>
<!-- #end of modal-dialog -->
@endif