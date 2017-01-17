@if(Permission::check('ease-country'))
<li  class="has-sub @if(Request::is('crud/*')) expand @endif">

    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-bank"></i>
        <span>CRUD v1.0</span>
    </a>

    <ul class="sub-menu" style="@if(Request::is('crud/*')) display: block; @endif">


        @if(Permission::check('crud-read'))
        <li @if(Request::is('crud/index')) class="active" @endif ><a href="{{URL::route('crud-index')}}"><i
                        class="fa fa-exchange"></i> List</a></li>
        @endif

    </ul>
</li>
@endif