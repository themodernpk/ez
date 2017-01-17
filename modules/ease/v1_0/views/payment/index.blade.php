@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
@stop


@section('content')

    <div class="">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#default-tab-1" data-toggle="tab">Service Payment</a></li>
            <li class=""><a href="#default-tab-0" data-toggle="tab">Wallet Payment</a></li>
            <li class=""><a href="#default-tab-2" data-toggle="tab">Cancelletion Payment</a></li>
            <li class=""><a href="#default-tab-3" data-toggle="tab">Commission Payment</a></li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane fade active in" id="default-tab-1">
                <h3>Service Payment</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="20">#</th>
                        <th>Seeker</th>
                        <th>Provider</th>
                        <th>Payment Through</th>
                        <th>Amount</th>
                        <th>Performed At</th>
                        <th>Status</th>
                        <th>Service Request</th>
                        <th width="30"></th>

                        @if(Permission::check($data['EaseServicePayment']['prefix'].'-update'))

                            <th width="120">Actions</th>
                            <th width="20"><input id="selectall" type="checkbox"/></th>
                        @endif
                    </tr>


                    @foreach($data['EaseServicePayment']['list'] as $item)

                        {{View::make($data['EaseServicePayment']['view'].'.index-item')->with('item', $item)->with('data', $data)->render()}}
                    @endforeach


                </table>
            </div>
            <div class="tab-pane fade" id="default-tab-0">
                <h3>Wallet Payment</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="20">#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Performed At</th>
                        <th>Status</th>
                        <th width="30"></th>
                        {{--@if(Permission::check($data->prefix.'-update'))

                            <th width="120">Actions</th>
                            <th width="20"><input id="selectall" type="checkbox"/></th>
                        @endif--}}
                    </tr>

                    {{--@foreach($data->list as $item)
                        {{View::make($data->view.'wallet.index-item')->with('item', $item)->with('data', $data)->render()}}
                    @endforeach--}}
                </table>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
                <h3>Cancelletion Payment</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="20">#</th>
                        <th>Seeker</th>
                        <th>Amount</th>
                        <th>Payment Through</th>
                        <th>Performed At</th>
                        <th>Service Request</th>
                        <th>Status</th>
                        <th width="30"></th>
                        {{--@if(Permission::check($data->prefix.'-update'))

                            <th width="120">Actions</th>
                            <th width="20"><input id="selectall" type="checkbox"/></th>
                        @endif--}}
                    </tr>

                    {{--@foreach($data->list as $item)
                        {{View::make($data->view.'cancelletion.index-item')->with('item', $item)->with('data', $data)->render()}}
                    @endforeach--}}
                </table>
            </div>
            <div class="tab-pane fade" id="default-tab-3">
                <h3>Commission Payment</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="20">#</th>
                        <th>Provider</th>
                        <th>Amount</th>
                        <th>Performed At</th>
                        <th>Payment Through</th>
                        <th>Ease Service Request Id</th>
                        <th>Status</th>
                        <th width="30"></th>
                        {{--@if(Permission::check($data->prefix.'-update'))

                            <th width="120">Actions</th>
                            <th width="20"><input id="selectall" type="checkbox"/></th>
                        @endif--}}
                    </tr>

                    {{--@foreach($data->list as $item)
                        {{View::make($data->view.'commission.index-item')->with('item', $item)->with('data', $data)->render()}}
                    @endforeach--}}
                </table>
            </div>
        </div>
</div>
@stop


@section('page_specific_foot')
@stop