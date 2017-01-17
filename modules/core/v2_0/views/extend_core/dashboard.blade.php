

    @if(Permission::check('allow-dashboard-activity-log'))

        <!-- begin col-6 -->
        <div class="col-md-6 ui-sortable">
            <div class="panel panel-inverse" data-sortable-id="flot-chart-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                           data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                           data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                           data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Recent Activities</h4>
                </div>
                <div class="panel-body">
                    <?php $items = Activity::get(); ?>

                    <table class="table table-striped table-hover table-bordered small">
                        @foreach ($items as $item)
                            <tr>
                                <td># {{$item->id}}</td>
                                <td>
                                    @if(!is_null($item->label))
                                        <span class="label"
                                              style="background-color: {{Common::stringToColorCode($item->label)}};">{{$item->label}}</span>
                                    @endif
                                    {{$item->content}}
                                </td>
                                <td>
                                    {{ Dates::showTimeAgo($item->created_at) }}
                                    @if(!is_null($item->user_id))
                                        <em>by
                                            <a href="{{URL::route('profile', array('id' => $item->user_id) )}}">{{@$item->user->name}}</a>
                                        </em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
        @endif
