<!-- begin #header -->
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="{{URL::to('/')}}" class="navbar-brand"><span
                        class="navbar-logo"></span> {{Setting::value('app-name')}}</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right hide-on-sm-device">

            <li class="dropdown">
                <a href="<?php echo URL::route('notification'); ?>?format=json&realteime=true" data-toggle="dropdown"
                   data-href="<?php echo URL::route('notification'); ?>?format=json&markasread=false"
                   data-href-realtime="<?php echo URL::route('notification'); ?>?format=json&realtime=true"
                   class="dropdown-toggle f-s-14 markRead">
                    <i class="fa fa-bell-o"></i>
                    <span class="label num_noti">{{Notification::count_unread()}}</span>
                </a>

            </li>

            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{User::thumbnail()}}" alt=""/>
                    <span class="hidden-xs">{{Auth::user()->name}}</span> <b class="caret"></b>
                </a>



                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
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





        </ul>
        <!-- end header navigation right -->


        <?php
        $modules = modules_list();
        foreach($modules as $module)
        {
        ?>
        @if(View::exists($module.'::extend_core.header_navigation'))
            @include($module.'::extend_core.header_navigation')
        @endif
        <?php
        }
        ?>





    </div>
    <!-- end container-fluid -->
</div><!-- end #header -->