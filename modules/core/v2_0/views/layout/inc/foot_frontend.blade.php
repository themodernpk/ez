<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo asset_path(); ?>/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/bootstrap/js/bootstrap.min.js"></script><!--[if lt IE 9]>
<script src="<?php echo asset_path(); ?>/crossbrowserjs/html5shiv.js"></script>
<script src="<?php echo asset_path(); ?>/crossbrowserjs/respond.min.js"></script>
<script src="<?php echo asset_path(); ?>/crossbrowserjs/excanvas.min.js"></script><![endif]-->
<script src="<?php echo asset_path(); ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/gritter/js/jquery.gritter.js"></script>
<script src="<?php echo asset_path(); ?>/plugins/parsley/dist/parsley.js"></script>

<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->

@yield('page_specific_foot')

<!-- ================== END PAGE LEVEL JS ================== -->

<!-- ================== COMMON ================== -->

<script src="<?php echo asset_path(); ?>/js/apps.min.js"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
</script>


<!-- ================== END COMMON ================== -->