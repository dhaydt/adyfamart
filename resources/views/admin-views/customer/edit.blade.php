@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Customer_Add'))

@push('css_or_js')
<link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('customer_add')}}</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{\App\CPU\translate('customer_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.customer.edit.post')}}" method="post" enctype="multipart/form-data"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @csrf
                        <input type="hidden" name="id" value="{{ $customer->id }}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('NIK')}}</label>
                                    <input type="text" name="id_member" class="form-control" id="id_member"
                                        value="{{ $customer->id_member }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('Name')}}</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{$customer->f_name}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('Phone')}}</label>
                                    <input type="number" name="phone" value="{{$customer->phone}}" class="form-control" id="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('Email')}} <small class="text-danger">(optional)</small></label>
                                    <input type="email" name="email" value="{{ $customer->email }}" class="form-control" id="email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('Password')}}</label>
                                    <input type="password" name="password" value="" class="form-control" id="password">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('Address')}}</label>
                                    <textarea class="form-control" name="address" cols="30" rows="3">{{ $customer->street_address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{\App\CPU\translate('customer_image')}}</label><span class="badge badge-soft-danger">( {{\App\CPU\translate('ratio')}} 1:1 )</span>
                                    <br>
                                    <div class="form-group">
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileUpload">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('file')}}</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/profile')}}/{{$customer['image']}}" alt="Customer thumbnail"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-4">
                            <button type="submit" class="btn btn-primary ml-auto">{{\App\CPU\translate('Update')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>
@endpush
