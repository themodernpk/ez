@if(isset($data['start']))
<!--panel start-->
<div class="panel-group" id="{{$data['id']}}">
        @endif

    <!--panel item-->
    @if(isset($data['title_start']))
    <div class="panel panel-inverse overflow-hidden">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse"
                   data-parent="#{{$data['panel_id']}}"
                   href="#{{$data['panel_item_id']}}" aria-expanded="false">
                    <i class="fa fa-plus-circle pull-right"></i>
                    @endif

                    @if(isset($data['title_end']))
                </a>
            </h3>
        </div>
        @endif


        @if(isset($data['body_start']))
        <div id="{{$data['panel_item_id']}}" class="panel-collapse collapse" aria-expanded="false">
            <div class="panel-body">
                @endif


                @if(isset($data['body_end']))
            </div>
        </div>
    </div>
        @endif
    <!--/panel item-->


        @if(isset($data['end']))
</div>
<!--/panel end-->
    @endif
