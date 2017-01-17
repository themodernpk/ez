@if(Permission::check('teacher-read'))
<li  class="has-sub @if(Request::is('teacher/*')) expand @endif">

    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-bank"></i>
        <span>TEACHER v1.0</span>
    </a>

    <ul class="sub-menu" style="@if(Request::is('teacher/*')) display: block; @endif">


        @if(Permission::check('teacher-read'))
        <li @if(Request::is('teacher/index')) class="active" @endif ><a href="{{URL::route('teacher-index')}}"><i
                        class="fa fa-exchange"></i> Teacher</a></li>
        @endif

    </ul>
</li>
@endif