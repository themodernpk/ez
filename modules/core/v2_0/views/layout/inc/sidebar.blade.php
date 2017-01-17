<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="{{User::thumbnail()}}" alt=""/></a>
                </div>
                <div class="info">
                    {{Auth::user()->name}}
                    {{--<small>Front end developer</small>--}}
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">{{constant('core_nav_header')}}</li>
            <?php
            $modules = modules_list();
            foreach($modules as $module)
            {
            ?>
            @if(View::exists($module.'::extend_core.navigation'))
                @include($module.'::extend_core.navigation')
            @endif
            <?php
            }
            ?>

            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                            class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div><!-- end #sidebar -->