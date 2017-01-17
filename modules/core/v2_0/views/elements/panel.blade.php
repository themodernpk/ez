@if(isset($data['start']))
<!--modal start-->
<div class="panel panel-inverse">
    <div class="panel-heading">

        @if(isset($data['head_button']))
        <div class="btn-group pull-right">
            <a href="{{$data['head_button_modal_id']}}" data-toggle="modal" class="btn btn-success btn-xs"><i
                        class="fa fa-plus"></i> {{$data['head_button']}}</a>
        </div>
        @endif

        @if(isset($data['title']))
        <h4 class="panel-title">{{$data['title']}}</h4>
            @endif

    </div>
    <div class="panel-body @if(isset($data['panel-body-class'])) {{$data['panel-body-class']}} @endif">
        @endif


        @if(isset($data['end']))
    </div>
</div>
<!--modal end-->
    @endif
