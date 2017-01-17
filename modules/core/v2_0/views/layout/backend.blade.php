<!DOCTYPE html><!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]--><!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
@include('core::layout.inc.head')
<body class="<?php echo body_class(); ?>">
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    @include('core::layout.inc.header')
    @include('core::layout.inc.sidebar')
    <!-- begin #content -->
    <div id="content" class="content">
        @include('core::layout.inc.error_msg')
        @include('core::layout.inc.flash_msg')
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            {{breadcrumb()}}
        </ol>
        <!-- end breadcrumb -->
        <!--content part-->
        @yield('content')
        <!--content part-->
    </div>
    <!-- end #content -->
</div>
@include('core::layout.inc.foot')

</body>
</html>