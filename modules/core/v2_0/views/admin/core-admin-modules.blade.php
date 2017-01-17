@extends('core::layout.backend')

@section('page_specific_head')


@stop



@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">

        <!-- begin col-10 -->
        <div class="col-md-12">

            @foreach($data['list'] as $item)




                @if($item['details'] == "details.xml does not exist")
                    <div class="row">
                        <div class="col-md-3">


                            <div class="panel panel-default">
                                <div class="panel-heading">Developer</div>
                                <div class="panel-body search-result"></div>
                            </div>


                        </div>

                        <div class="col-md-9">

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{strtoupper($item['name'])}}</h3>
                                </div>
                                <div class="panel-body">
                                    {{$item['details']}}
                                </div>
                            </div>

                        </div>
                    </div>


                @else



                    <div class="row">
                        <div class="col-md-3">



                        </div>

                        <div class="col-md-11">

                            <div class="panel panel-primary">
                                <div class="panel-heading" style="background: #1abc9c">
                                    <h3 class="panel-title">{{strtoupper($item['name'])}}</h3>
                                </div>
                                <div class="panel-body">


                                    <p>{{ucfirst(nl2br($item['details']->description))}}</p>

                                    <p><span class="label"
                                             style="color: gray; margin-top: 23px;"> By {{$item['details']->developer}}
                                            | {{Dates::dateformat($item['details']->date)}}</span></p>

                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                        <?php
                                        $i = 0;
                                        $latest_version = max(array_keys($item['versions']));
                                        foreach($item['versions'] as $ver => $ver_d){ ?>

                                        <div class="panel panel-inverse overflow-hidden">
                                            <div class="panel-heading" role="tab" id="heading{{$item['name']}}{{$i}}"
                                                 style="background: #bdc3c7;">

                                                @if(isset($item['active']->version) && $ver == $item['active']->version  )
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#{{$item['name']}}{{$i}}" aria-expanded="false"
                                                       aria-controls="{{$item['name']}}{{$i}}">
                                                        <span class="badge">Version {{$ver}}</span>
                                                        <span class="label label-success">Active</span>

                                                        <i class="fa fa-plus-circle pull-right"
                                                           style=" color: black;"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#{{$item['name']}}{{$i}}" aria-expanded="false"
                                                       aria-controls="{{$item['name']}}{{$i}}">
                                                        <span class="badge label-primary">Version {{$ver}}</span>

                                                        <i class="fa fa-plus-circle pull-right"
                                                           style="color: black;"></i>
                                                    </a>
                                                @endif

                                                @if($item['name'] == 'core' && $ver == "1.0" )

                                                    You can't uninstall core module


                                                @else
                                                        {{ Form::open(array('route' => 'moduleInstall', 'role' => 'form', 'class' => 'actModule pull-right', 'style' => 'display:inline-block')) }}

                                                        @if(isset($item['active']->version) && $ver == $item['active']->version  )
                                                            <button type="submit"
                                                                    class="pull-right btn btn-danger btn-xs submit-module">
                                                                <i class="fa fa-spinner"></i> Uninstall
                                                            </button>
                                                            {{Form::hidden('task', 'uninstall')}}
                                                        @elseif(isset($item['active']->version) && $ver < $item['active']->version)
                                                            <span class="pull-right btn btn-default btn-xs submit-module">Outdated</span>
                                                            {{Form::hidden('task', 'install')}}
                                                        @elseif(isset($item['active']->version) && $ver > $item['active']->version)
                                                            <button type="submit"
                                                                    class="pull-right btn btn-warning btn-xs submit-module">
                                                                <i class="fa fa-spinner"></i> Upgrade
                                                            </button>
                                                            {{Form::hidden('task', 'upgrade')}}
                                                            {{Form::hidden('active_version', $item['active']->version)}}
                                                        @else

                                                            {{Form::hidden('task', 'install')}}
                                                            <button type="submit"
                                                                    class="pull-right btn btn-info btn-xs submit-module"><i
                                                                        class="fa fa-spinner"></i> Install
                                                            </button>

                                                        @endif

                                                        {{Form::hidden('name', $item['name'])}}
                                                        {{Form::hidden('version', $ver)}}

                                                        {{ Form::close() }}

                                                @endif

                                            </div>


                                            <div id="{{$item['name']}}{{$i}}" class="panel-collapse collapse"
                                                 role="tabpanel" aria-labelledby="heading{{$item['name']}}{{$i}}">
                                                <div class="panel-body">
                                                    @if(is_object($ver_d) )
                                                        <p>{{nl2br($ver_d->description)}}</p>
                                                        <p>
                                                            <span class="label label-primary"><i
                                                                        class="fa fa-code"></i> {{$ver_d->developer}}</span>
                                                            <span class="label label-primary"><i
                                                                        class="fa fa-calendar"></i> {{Dates::dateformat($ver_d->date)}}</span>
                                                        </p>


                                                    @else
                                                        <p>{{$ver_d}}</p>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++; } ?>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>


                @endif


            @endforeach
        </div>
        <!-- end col-10 -->
    </div>
    <!-- end row -->



@stop

@section('page_specific_foot')


    <script type="text/javascript">
        $(document).ready(function () {


            $('.actModule').submit(function () {

                $(this).find('.submit-module').children('i').addClass('fa-spin');

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serialize(),

                    context: this,
                    success: function (response) {


                        if (response == 'ok') {
                            $(this).find('.submit-module').children('i').removeClass('fa-spinner');
                            $(this).find('.submit-module').children('i').removeClass('fa-spin');
                            $(this).find('.submit-module').children('i').addClass('fa-check');
                            $(this).find('.submit-module').removeClass('btn-info');
                            $(this).find('.submit-module').addClass('btn-success');
                        } else {
                            console.log(response);
                            alert(response);
                        }
                    }
                });

                return false;


            });
        });

    </script>






@stop