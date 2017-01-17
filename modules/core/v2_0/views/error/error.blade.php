@extends('core::layout.core')


@section('content')


    <div class="container ">

        <div class="row featurette mr_top_140">
            <div class="col-md-12 center">
                @include('core::layout.inc.error_msg')
                @include('core::layout.inc.flash_msg')

                <div class="col-md-12 center">
                    <a class="btn btn-default" href="{{URL::previous()}}">Go Back</a>
                </div>

                <div class="">
                    <h2 class="bigbold black">Error!</h2>
                </div>

                <div class="col-md-12 center">
                    <ul class="nav nav-hori-center">

                        <li><a href="{{URL::to('/')}}">Home</a></li>
                        <li><a href="{{URL::route('login')}}">Login</a></li>
                        <li><a href="{{URL::route('register')}}">Register</a></li>
                        @if(Auth::check())
                            <li><a href="{{URL::route('dashboard')}}">Dashboard</a></li>
                        @endif


                    </ul>
                </div>


            </div>

        </div>


    </div>
@stop