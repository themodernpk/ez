{{--for country--}}

@if(Permission::check('ease'))
    <li  class="has-sub @if(Request::is('ease-admin/*')) expand @endif">

        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-bank"></i>
            <span>EASE v1.0</span>
        </a>
        <ul class="sub-menu" style="@if(Request::is('ease-admin/*')) display: block; @endif">


            @if(Permission::check('ease-country-read'))
                <li @if(Request::is('country/index')) class="active" @endif ><a href="{{URL::route('ease-country-index')}}"><i
                                class="fa fa-exchange"></i> Countries</a></li>
            @endif

            @if(Permission::check('ease-faq-read'))
                <li @if(Request::is('faq/index')) class="active" @endif ><a href="{{URL::route('ease-faq-index')}}"><i
                                class="fa fa-exchange"></i> FAQs</a></li>
            @endif

            @if(Permission::check('ease-service-read'))
                <li @if(Request::is('service/index')) class="active" @endif ><a href="{{URL::route('ease-service-index')}}"><i
                                class="fa fa-exchange"></i> Services</a></li>
            @endif
            @if(Permission::check('ease-tnc-read'))
                <li @if(Request::is('tnc/index')) class="active" @endif ><a href="{{URL::route('ease-tnc-index')}}"><i
                                class="fa fa-exchange"></i> T&Cs</a></li>
            @endif

            @if(Permission::check('ease-offer-read'))
                <li @if(Request::is('offer/index')) class="active" @endif ><a href="{{URL::route('ease-offer-index')}}"><i
                                class="fa fa-exchange"></i> Offers</a></li>
            @endif

            @if(Permission::check('ease-coupon-read'))
                <li @if(Request::is('coupon/index')) class="active" @endif ><a href="{{URL::route('ease-coupon-index')}}"><i
                                class="fa fa-exchange"></i> Coupons</a></li>
            @endif

            @if(Permission::check('ease-profession-level-read'))
                <li @if(Request::is('profession-level/index')) class="active" @endif ><a href="{{URL::route('ease-profession-level-index')}}"><i
                                class="fa fa-exchange"></i> Profession levels</a></li>
            @endif

            @if(Permission::check('ease-seeker-read'))
                <li @if(Request::is('seeker/index')) class="active" @endif ><a href="{{URL::route('ease-seeker-index')}}"><i
                                class="fa fa-exchange"></i> Seekers</a></li>
            @endif

            @if(Permission::check('ease-support-read'))
                <li @if(Request::is('support/index')) class="active" @endif ><a href="{{URL::route('ease-support-index')}}"><i
                                class="fa fa-exchange"></i> Supports</a></li>
            @endif

                @if(Permission::check('ease-setting-read'))
                    <li @if(Request::is('setting/index')) class="active" @endif ><a href="{{URL::route('ease-setting-index')}}"><i
                                    class="fa fa-exchange"></i> Settings</a></li>
                @endif

            @if(Permission::check('ease-provider-read'))
                <li @if(Request::is('provider/index')) class="active" @endif ><a href="{{URL::route('ease-provider-index')}}"><i
                                class="fa fa-exchange"></i> Providers</a></li>
            @endif

            @if(Permission::check('ease-report-issue-read'))
                <li @if(Request::is('report-issue/index')) class="active" @endif ><a href="{{URL::route('ease-report-issue-index')}}"><i
                                class="fa fa-exchange"></i> Reported issues</a></li>
            @endif

            @if(Permission::check('ease-payment-read'))
                <li @if(Request::is('payment/index')) class="active" @endif ><a href="{{URL::route('ease-payment-index')}}"><i
                                class="fa fa-exchange"></i> Payments</a></li>
            @endif

            @if(Permission::check('ease-review-read'))
                <li @if(Request::is('review/index')) class="active" @endif ><a href="{{URL::route('ease-review-index')}}"><i
                                class="fa fa-exchange"></i> Reviews</a></li>
            @endif

                {{--@if(Permission::check('ease-user-read'))
                    <li @if(Request::is('user/index')) class="active" @endif ><a href="{{URL::route('ease-user-index')}}"><i
                                    class="fa fa-exchange"></i> Ease Users</a></li>
                @endif--}}

        </ul>
    </li>
@endif
