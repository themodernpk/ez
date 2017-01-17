<ul class="dropdown-menu media-list pull-right animated fadeInDown">
    <li class="dropdown-header">Notifications</li>
    <?php
    $notifications = Notification::get();
    if(count($notifications) > 0 )
    {
    ?>
    @foreach($notifications as $item)
        <li class="media notifications">
            <a href="{{$item->link}}">
                <div class="media-left"><i class="fa <?php if ($item->icon != NULL) {
                        echo $item->icon;
                    } else {
                        echo "fa-bell bg-grey";
                    } ?> media-object"></i></div>
                <div class="media-body">
                    <p>
                        @if($item->read == 1)
                            {{$item->content}}
                        @else
                            <b>{{$item->content}}</b>
                        @endif

                    </p>
                    <div class="text-muted f-s-11">{{Dates::showTimeAgo($item->created_at)}}</div>
                </div>
            </a>
        </li>
    @endforeach
    <?php } ?>
    <li class="dropdown-footer text-center">
        <a href="{{URL::route('notifications')}}">View more</a>
    </li>
</ul>