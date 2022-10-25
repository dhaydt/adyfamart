<!-- Footer -->
<style>
    .page-footer {
        /* background-color: #f2f3f7; */
        background-color: #fff;
    }
    h6.footer-heder {
        color: #000;
    }
    .widget-list .widget-list-item a.widget-list-link, .social-media .social-btn {
        color: #000 !important;
    }

    .social-btn {
        border: 1px solid #000;
    }

    .sb-light.social-btn.sb-twitter:hover {
        /* background-color: #1da1f2 !important; */
        box-shadow: 0 0.5rem 1.125rem -0.5rem rgb(29 161 242 / 90%);
    }

    .social-media :hover {
        color: {{$web_config['secondary_color']}} !important;
    }
    .widget-list-link{
        color: #999898 !important;
    }

    .widget-list-link:hover{
        color: white !important;
    }

    .page-footer hr {
        border: 0.001px solid #cccbcb
    }

    .page-footer{
        color: #000 !important;
    }

    .bank-logo img{
        height: 25px !important;
    }
</style>

<footer class="page-footer font-small mdb-color pt-3 rtl d-none d-md-block">
    <!-- Footer Links -->
    <div class="container text-center" style="padding-bottom: 13px;">

        <!-- Footer links -->
        <div
            class="row text-center {{Session::get('direction') === "rtl" ? 'text-md-right' : 'text-md-left'}} mt-3 pb-3">

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="text-uppercase mb-2 font-weight-bold footer-heder">{{\App\CPU\translate('about_us')}}</h6>


                <ul class="widget-list" style="padding-bottom: 10px">
                    {{-- <p class="widget-list-item">{!! substr($web_config['about']->value,0,100) !!}</p> --}}
                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('about-us')}}">{{\App\CPU\translate('about_company')}}</a>
                    </li>
                    {{-- <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('helpTopic')}}">{{\App\CPU\translate('faq')}}</a></li>
                    <li class="widget-list-item "><a class="widget-list-link"
                                                    href="{{route('terms')}}">{{\App\CPU\translate('terms_&_conditions')}}</a>

                    </li>

                    <li class="widget-list-item ">
                        <a class="widget-list-link" href="{{route('privacy-policy')}}">
                            {{\App\CPU\translate('privacy_policy')}}
                        </a>
                    </li> --}}
                    <li class="widget-list-item "><a class="widget-list-link"
                                                    href="{{route('contacts')}}">{{\App\CPU\translate('contact_us')}}</a>

                    </li>
                </ul>
            </div>

            <!-- Grid column -->
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-2 font-weight-bold footer-heder">{{\App\CPU\translate('help')}} & {{ \App\CPU\Translate('information') }}</h6>
                <ul class="widget-list" style="padding-bottom: 10px">

                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('track-order.index')}}">{{\App\CPU\translate('track_order')}}</a>
                    </li>
                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{ route('account-tickets') }}">{{\App\CPU\translate('support_ticket')}}</a>
                    </li>
                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('helpTopic')}}">{{\App\CPU\translate('FAQ')}}</a>
                    </li>
                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('terms')}}">{{\App\CPU\translate('terms')}} & {{\App\CPU\translate('conditions')}}</a>
                    </li>

                    <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('privacy-policy')}}">{{\App\CPU\translate('privacy_policy')}}</a>
                    </li>
                    {{-- <li class="widget-list-item"><a class="widget-list-link"
                                                    href="{{route('categories')}}">{{\App\CPU\translate('all_category')}}</a>
                    </li> --}}

                </ul>
            </div>
            <!-- Grid column -->

            <hr class="w-100 clearfix d-md-none">

            <!-- Grid column -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h6 class="text-uppercase mb-3 font-weight-bold footer-heder">{{\App\CPU\translate('payment_method')}}</h6>
                    <ul class="widget-list" style="padding-bottom: 10px">
                        <li class="widget-list-item"><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/bca-ready.png")}}"
                            alt="payment">
                    </a><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/mandiri-ready.png")}}"
                            alt="payment">
                    </a><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/bri-ready.png")}}"
                            alt="payment">
                    </a><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/bni-ready.png")}}"
                            alt="payment">
                    </a>
                    <a class="bank-logo" href="javascript:void(0)" role="button"><img class="pt-2 mt-1"
                            src="{{asset("public/assets/front-end/img/cimb-ready.png")}}"
                            alt="payment">
                    </a>
                        </li>
                        <li class="widget-list-item mt-3">
                            <a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                                src="{{asset("public/assets/front-end/img/ovo-ready.png")}}"
                                alt="payment">
                        </a><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                                src="{{asset("public/assets/front-end/img/dana-ready.png")}}"
                                alt="payment">
                        </a>
                        <a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/link-ready.png")}}"
                            alt="payment">
                        </a>
                        <a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/shopee-ready.png")}}"
                            alt="payment">
                        </a>
                        </li>

                        <li class="widget-list-item mt-3">
                            <a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                                src="{{asset("public/assets/front-end/img/qris-ready.png")}}"
                                alt="payment">
                        </a>
                            <a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/indo-ready.png")}}"
                            alt="payment">
                    </a><a class="mr-2 bank-logo" href="javascript:void(0)" role="button"><img
                            src="{{asset("public/assets/front-end/img/alfa-ready.png")}}"
                            alt="payment">
                    </a>
                        </li>
                        {{-- <li class="widget-list-item"><a class="widget-list-link"
                                                        href="{{ route('account-address') }}">{{\App\CPU\translate('address')}}</a>
                        </li>
                        <li class="widget-list-item"><a class="widget-list-link"
                                                        href="{{ route('account-tickets') }}">{{\App\CPU\translate('support_ticket')}}</a>
                        </li> --}}

                    </ul>

            </div>

            <!-- Grid column -->
            <hr class="w-100 clearfix d-md-none">

            <!-- Grid column -->
            <div class="col-md-3 col-lg-3 col-xl-3 mt-3">
                <div class="text-nowrap mb-4">
                    <a class="d-inline-block mt-n1" href="{{route('home')}}">
                        <img width="250" style="height: 60px!important;"
                             src="{{asset("storage/app/public/company/")}}/{{ $web_config['footer_logo']->value }}"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             alt="{{ $web_config['name']->value }}"/>
                    </a>
                </div>
                @php($social_media = \App\Model\SocialMedia::where('active_status', 1)->get())
                @if(isset($social_media))
                    @foreach ($social_media as $item)
                        <span class="social-media">
                                <a class="social-btn sb-light sb-{{$item->name}} {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} mb-2"
                                   target="_blank" href="{{$item->link}}" style="color: black!important;">
                                    <i class="{{$item->icon}}" aria-hidden="true"></i>
                                </a>
                            </span>
                    @endforeach
                @endif

                <div class="widget mb-4 for-margin">
                    @php($ios = \App\CPU\Helpers::get_business_settings('download_app_apple_stroe'))
                    @php($android = \App\CPU\Helpers::get_business_settings('download_app_google_stroe'))

                    @if($ios['status'] || $android['status'])
                        <h6 class="text-uppercase font-weight-bold footer-heder">
                            {{\App\CPU\translate('download_our_app')}}
                        </h6>
                    @endif


                    <div class="store-contents" style="display: flex;">
                        @if($ios['status'])
                            <div class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} mb-2">
                                <a class="" href="{{ $ios['link'] }}" role="button"><img
                                        src="{{asset("public/assets/front-end/png/apple_app.png")}}"
                                        alt="" style="height: 40px!important;">
                                </a>
                            </div>
                        @endif

                        @if($android['status'])
                            <div class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} mb-2">
                                <a href="{{ $android['link'] }}" role="button">
                                    <img src="{{asset("public/assets/front-end/png/google_app.png")}}"
                                         alt="" style="height: 40px!important;">
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <!-- Grid column -->

            <hr class="w-100 clearfix d-md-none">
            <!-- Grid column -->
        </div>
        <!-- Footer links -->
    </div>

    <hr>
    <!-- Grid row -->
    <div class="container text-center">
        <div class="row d-flex align-items-center footer-end">
            <div class="col-md-12 mt-3">
                <p class="text-center" style="font-size: 12px;">{{ $web_config['copyright_text']->value }}</p>
            </div>
        </div>
        <!-- Grid row -->
    </div>
    <!-- Footer Links -->
</footer>
<!-- Footer -->
