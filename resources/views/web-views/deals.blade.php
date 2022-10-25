@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Flash Deal Products'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Deals of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Deals of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <style>
        .for-banner {
            margin-top: 15px;
        }

        .for-banner img {
            border-radius: 10px;
        }

        .counter{
            justify-content:start;
        }

        .deal_product {
            margin-bottom: 10px
        }

        .cz-countdown-days {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px !important;
        }

        .cz-countdown-hours {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px !important;
        }

        .flash_deal_title {
            font-weight: 700;
            font-size: 30px;

            text-transform: uppercase;
        }

        .cz-countdown {
            font-size: 18px;
        }

        .cz-countdown-minutes {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px !important;
        }

        .cz-countdown-seconds {
            color: {{$web_config['primary_color']}};
            border: 1px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px !important;
        }

        .flash_deal_product_details .flash-product-price {
            font-weight: 700;
            font-size: 25px;
            color: {{$web_config['primary_color']}};
        }

        .for-image {
            width: 100%;
            height: 200px;
        }

        @media (max-width: 600px) {
            .counter {
                justify-content: space-between
            }
            .flash_deal_title {
                font-weight: 600;
                font-size: 14px !important;
            }

            .cz-countdown {
                font-size: 14px;
            }

            .counter .cz-countdown .cz-countdown-value {
                font-size: 12px !important;
            }

            .for-image {

                height: 100px;
            }

            .deal_product {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .for-deal-tab {
                display: contents;
            }


        }
    </style>
@endpush

@section('content')
    <div class="for-banner container rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">

        <img class="d-block for-image"
             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
             src="{{asset('storage/app/public/deal')}}/{{$deal['banner']}}"
             alt="Shop Converse">

    </div>
    <div class="container md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <section class="col-lg-12 for-deal-tab">
                @php($flash_deals=\App\Model\FlashDeal::with(['products.product.reviews'])->where(['status'=>1])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())
                <div class="col-md-6 col-12  pt-2">
                    <div class="row d-inline-flex w-100 counter">
                        <span class="flash_deal_title {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">
                            {{ \App\CPU\translate('flash_deal')}}
                        </span>
                        <span class="cz-countdown mt-2"
                              data-countdown="{{isset($flash_deals)?date('m/d/Y',strtotime($flash_deals['end_date'])):''}} 11:59:00 PM">
                        <span class="cz-countdown-days">
                            <span class="cz-countdown-value"></span>
                        </span>
                        <span class="cz-countdown-value">:</span>
                        <span class="cz-countdown-hours">
                            <span class="cz-countdown-value"></span>
                        </span>
                        <span class="cz-countdown-value">:</span>
                        <span class="cz-countdown-minutes">
                            <span class="cz-countdown-value"></span>
                        </span>
                        <span class="cz-countdown-value">:</span>
                        <span class="cz-countdown-seconds">
                            <span class="cz-countdown-value"></span>
                        </span>
                    </span>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Toolbar-->

    <!-- Products grid-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <section class="col-lg-12">
                <div class="row">
                    @if($discountPrice)
                        @foreach($deal->products as $dp)
                            <div class="col-xl-2 col-sm-3 col-6 deal_product" style="">
                                @include('web-views.partials._list_single_product',['product'=>$dp->product])
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')

@endpush
