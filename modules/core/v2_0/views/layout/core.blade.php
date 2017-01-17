<!DOCTYPE html><!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]--><!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
@include('core::layout.inc.head')
<body class="<?php echo body_class(); ?>">
<!--content part-->
@yield('content')
<!--content part-->
@include('core::layout.inc.foot_frontend')
</body>
</html>