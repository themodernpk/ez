<li class="@if(Request::is('dashboard')) active @endif">
    <a href="{{URL::route('dashboard')}}">
        <i class="fa fa-dashboard"></i><span>Dashboard</span>
    </a>
</li>

@if(Permission::check('show-admin-section'))
    <li class="has-sub @if(Request::is('admin/*')) expand @endif">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-briefcase"></i>
            <span>Admin v2.0</span>
        </a>
        <ul class="sub-menu" style="@if(Request::is('admin/*')) display: block; @endif">


            @if(Permission::check('core-permission-read'))
            <li @if(Request::is('admin/permission/index')) class="active" @endif ><a href="{{URL::route('core-permission-index')}}"><i
                            class="fa fa-key"></i> Permissions</a></li>
            @endif

            @if(Permission::check('core-group-read'))
            <li  @if(Request::is('admin/group/index')) class="active" @endif><a href="{{URL::route('core-group-index')}}"> <i
                            class="fa fa-slideshare"> </i> Groups</a></li>
            @endif


                @if(Permission::check('core-user-read'))
            <li @if(Request::is('admin/user/index')) class="active" @endif><a href="{{URL::route('core-user-index')}}"> <i
                            class="fa fa-users"></i> Users</a></li>
                @endif


            <li class="divider"></li>
            @if(Permission::check('view-activities'))
                <li @if(Request::is('admin/activities/list')) class="active" @endif><a href="{{URL::route('activities')}}"><i
                                class="fa fa-flag"></i> Activities</a></li>
            @endif
            <li @if(Request::is('admin/modules')) class="active" @endif><a href="{{URL::route('modules')}}"><i
                            class="fa fa-cubes"></i> Modules</a></li>

            <li @if(Request::is('admin/setting')) class="active" @endif><a href="{{URL::route('setting')}}"><i
                            class="fa fa-cog"></i> Settings</a></li>


        </ul>
    </li>
@endif

    <li class="has-sub sidebar-user-menu-show @if(Request::is('user/*')) expand @endif">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-briefcase"></i>
            <span>My Account</span>
        </a>
        <ul class="sub-menu" style="@if(Request::is('user/*')) display: block; @endif">
            <?php
            $modules = modules_list();
            foreach($modules as $module)
            {
            ?>
            @if(View::exists($module.'::extend_core.usermenu'))
                @include($module.'::extend_core.usermenu')
            @endif
            <?php
            }
            ?>


        </ul>
    </li>




