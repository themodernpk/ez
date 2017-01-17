@extends('core::layout.backend')


@section('page_specific_head')

@stop


@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->

    <!-- end row -->
    <?php
    $modules = modules_list();
    foreach($modules as $module)
    {
    ?>
    @if(View::exists($module.'::extend_core.userprofile'))
        @include($module.'::extend_core.userprofile')
    @endif
    <?php
    }
    ?>
@stop

@section('page_specific_foot')


@stop
