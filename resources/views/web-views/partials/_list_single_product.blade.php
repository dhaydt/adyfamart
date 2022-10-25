<style>
    .for-dicount-div {
        margin-top: -6%;
        margin-bottom: 6%;
    }
    span.for-discoutn-value {
        padding: 5px 10px;
        right: -100px;
        top: -20px;
        position: absolute;
        font-weight: 600;
        text-transform: capitalize;
        border-radius: 0px 5px 0 15px;
        z-index: 1;
    }
    .product-card {
        margin-bottom: 40px;
        display: flex;
        max-width: 200px;
        align-items: center;
        justify-content: center;
    }
    .product-card.card label {
        left: 29%;
        top: 29% !important;
        font-size: 14px;
    }

    .card-header {
        cursor: pointer;
        max-height: 193px;
        min-height: 193px;
        padding: 0px;
        margin-bottom: -11px;
    }

    .product-title1 {
        text-transform: capitalize;
    }


    .card-body {
        cursor: pointer;
        max-height: 5.5rem;
        min-height: 5.5rem;
        margin-bottom: 23px;
    }
    .card-body-hidden {
        padding-bottom: 5px!important;
        min-height: 23px !important;
    }
    .center-div a img {
        min-width:200px;
        width: 100%;
        min-height: 200px;
        max-height: 200px!important;
    }
    .discount-div {
        margin: 5px 0;
    }
    .new-discoutn-value{
        background-color: {{ $web_config['secondary_color'] }};
        border-radius: 15px;
        font-size: 13px;
        color: #fff;
        font-weight: 600;
        padding: 2px 10px;
    }

    @media(min-width: 600px){
        .flash-card .card-header{
            position: relative;
        }
        .flash-card .card-header .center-div {
            position: absolute;
            top: -17px;
        }
        .flash-card .card-header .center-div img{
            border-radius: 5px 5px 0 0;
        }
    }

    @media (max-width: 600px) {
        span.for-discoutn-value{
            padding: 2px 9px;
            font-size: 12px;
            font-weight: 500;
            right: 0;
            top: 0;
            border-radius: 0px 5px 0 15px;
            z-index: 1;
        }
        .new-discoutn-value {
            font-size: 10px;
        }

        .for-dicount-div {
            margin-top: 0%;
            margin-bottom: 0%;
        }

        .card-header {
            max-height: 186px;
            min-height: 186px;
            margin-bottom: 5px;
        }
        .card-body {
            margin-top: -9px;
            max-height: 4.5rem;
            min-height: 4.5rem;
            margin-bottom: 43px !important;
        }
        .center-div {
            position: relative;
        }
        .center-div a img {
            min-width: 100%;
            max-height: 100% !important;
            min-height: 100%;
            border-radius: 5px 5px 0 0;
        }
        .product-card.card {
            margin-bottom: 0px !important;
            display: block;
            align-items: start;
            justify-content: start;
        }

        .product-card.card label {
            left: 25%;
            top: 25% !important;
        }
        .product-card.card {
            border-radius: 5px 5px;
        }
        .product-card.card .card-body-hidden {
            visibility: visible !important;
            opacity: 1 !important;
            margin-top: -28px;
            padding: 0 5px;
            padding-top: 0;
            z-index: 2;
        }
        .product-card.card .card-body-hidden .text-center a{
            font-size:10px;
        }
        .new-discoutn-value {
            font-size: 10px;
        }
        .discount-div {
            margin: 0;
            margin-top: -5px;
        }
        .product-title1 a{
            font-size: 12px;
        }
        .product-price {
            margin-top: -10px;
        }
        .product-price .text-accent {
            font-size: 14px !important;
        }
    }
    @media(max-width: 400px) {
        .card-header {
            max-height: 160px;
            min-height: 160px;
        }
    }
</style>
@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))
<div class="product-card card flash-card {{$product['current_stock']==0?'stock-card':''}}">
    @if($product['current_stock']<=0) <label
        class="badge badge-danger stock-out">{{\App\CPU\translate('stock_out')}}</label>
        @endif

        <div class="card-header inline_product clickable">
            @if(isset($product->label))
            <div class="d-flex justify-content-end for-dicount-div discount-hed">
                <span class="for-discoutn-value">
                    {{ $product->label }}
                </span>
            </div>
            @else
            <div class="d-flex justify-content-end for-dicount-div-null">
                <span class="for-discoutn-value-null"></span>
            </div>
            @endif
            <div class="center-div element-center" style="cursor: pointer">
                <a href="{{route('product',$product->slug)}}">
                    <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'">
                </a>
            </div>
        </div>

        <div class="card-body inline_product text-center p-1 clickable">
            <div style="position: relative;" class="product-title1">
                <a href="{{route('product',$product->slug)}}">
                    {{ Str::limit($product['name'], 25) }}
                </a>
            </div>
            <div class="justify-content-between text-center">
                <div class="product-price text-center">
                    @if($product->discount > 0)
                    <strike style="font-size: 12px!important;color: grey!important;">
                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                    </strike><br>
                    @endif

                    @if($product->discount > 0)
                    <div class="text-center discount-div">
                        <span class="new-discoutn-value">
                            {{\App\CPU\translate('off')}}
                            @if ($product->discount_type == 'percent')
                            {{round($product->discount,2)}}%
                            @elseif($product->discount_type =='flat')
                            {{\App\CPU\Helpers::currency_converter($product->discount)}}
                            @endif
                        </span>
                    </div>
                    @else
                    <div class="d-flex justify-content-end for-dicount-div-null">
                        <span class="for-discoutn-value-null"></span>
                    </div>
                    @endif

                    <span class="text-accent">
                        {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                        )}}
                    </span>
                </div>
            </div>

        </div>
        {{-- <div class="d-flex justify-content-left w-100" style="position: absolute;bottom: 11px;left: 15px;z-index: 2;">
            <div class="flag">
                <img class="{{Session::get('direction') === " rtl" ? 'ml-2' : 'mr-2' }}" width="20"
                    src="{{asset('public/assets/front-end')}}/img/flags/{{ strtolower($product['country'])  }}.png"
                    alt="Eng">
            </div>
           @php($c_name = App\Country::where('country', $product['country'])->get())
            <span style="font-size: 13px; color: #616166; line-height: 1.6;">{{ $c_name[0]->country_name }}</span>
        </div> --}}

        <div class="card-body card-body-hidden">
            <div class="text-center">
                @if(Request::is('product/*'))
                <a class="btn btn-primary btn-sm btn-block mb-2" href="{{route('product',$product->slug)}}">
                    <i class="czi-forward align-middle {{Session::get('direction') === " rtl" ? 'ml-1' : 'mr-1' }}"></i>
                    {{\App\CPU\translate('View')}}
                </a>
                @else
                <a class="btn btn-primary btn-sm btn-block mb-2" href="javascript:"
                onclick="addCart({{ $product->id }})">
                    <i style="font-weight: 900;font-size: 9px; margin-top: -1px;" class="czi-add align-middle {{Session::get('direction') === " rtl" ? 'ml-1' : 'mr-1' }}"></i>
                    Keranjang
                </a>
                @endif
            </div>
        </div>
</div>
@push('script')
<script>
    function addCart(val) {
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '/cart/add',
                data: {'id' : val, 'quantity': 1},
                beforeSend: function () {
                    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                        $('#loading').addClass('loading-mobile');
                    }
                    $('#loading').show();
                },
                success: function (response) {
                    // console.log(response);
                    if (response.status == 1) {
                        updateNavCart();
                        toastr.success(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('.call-when-done').click();
                        return false;
                    } else if (response.status == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: response.message
                        });
                        return false;
                    }
                },
                complete: function () {
                    $('#loading').hide();
                    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                        $('#loading').removeClass('loading-mobile');
                    }
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: 'Please choose all the options'
            });
        }
    }

</script>
@endpush
