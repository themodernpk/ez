<head>
    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="<?php echo asset_path(); ?>/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/css/theme/default.css" rel="stylesheet" id="theme" />
    <link href="<?php echo asset_path(); ?>/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php echo asset_path(); ?>/plugins/parsley/src/parsley.css" rel="stylesheet" />

    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo asset_path(); ?>/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!--page specific css & js-->
    @yield('page_specific_head')
    <!--page specific css & js-->

    <?php
    $modules = modules_list();
    foreach($modules as $module)
    {
    ?>
    @if(View::exists($module.'::extend_core.common_css'))
        @include($module.'::extend_core.common_css')
    @endif
    <?php
    }
    ?>

    <link href="<?php echo asset_path(); ?>/custom.css" rel="stylesheet" id="theme" />
</head>