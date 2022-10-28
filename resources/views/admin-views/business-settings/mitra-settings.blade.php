@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Mitra Settings'))

@push('css_or_js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('mitra_settings')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{\App\CPU\translate('admin')}} {{\App\CPU\translate('fee')}}
            {{\App\CPU\translate('Informations')}} </h4>
    </div>

    <div class="row" style="padding-bottom: 20px">
        @php($commission=\App\Model\BusinessSetting::where('type','admin_fee')->first())
        <div class="col-md-6">
            <div class="card-header">
                <h5>{{\App\CPU\translate('Admin Fee')}}</h5>
            </div>
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <form action="{{route('admin.business-settings.mitra-settings.update-mitra-settings')}}"
                        method="post">
                        @csrf
                        <label>{{\App\CPU\translate('Default Admin Fee')}} ( Rp. )</label>
                        <input class="form-control" name="commission"
                            value="{{isset($commission)?number_format($commission->value):0}}" min="0">
                        <hr>
                        <button type="submit" class="btn btn-primary {{Session::get('direction') === " rtl"
                            ? 'float-left mr-3' : 'float-right ml-3' }}">{{\App\CPU\translate('Save')}}</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-web-Logo'])
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-mobile-Logo'])
    @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-footer-Logo'])
    @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-fav-icon'])
</div>
@endsection

@push('script')
<script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
<script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
<script>
    function readWLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWL").change(function () {
            readWLURL(this);
        });

        function readWFLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWFL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWFL").change(function () {
            readWFLURL(this);
        });

        function readMLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerML').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadML").change(function () {
            readMLURL(this);
        });

        function readFIURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerFI').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadFI").change(function () {
            readFIURL(this);
        });


        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

</script>

@include('shared-partials.image-process._script',[
'id'=>'company-web-Logo',
'height'=>200,
'width'=>784,
'multi_image'=>false,
'route'=>route('image-upload')
])
@include('shared-partials.image-process._script',[
'id'=> 'company-footer-Logo',
'height'=>200,
'width'=>784,
'multi_image'=>false,
'route' => route('image-upload')

])
@include('shared-partials.image-process._script',[
'id'=> 'company-fav-icon',
'height'=>100,
'width'=>100,
'multi_image'=>false,
'route' => route('image-upload')

])
@include('shared-partials.image-process._script',[
'id'=>'company-mobile-Logo',
'height'=>200,
'width'=>784,
'multi_image'=>false,
'route'=>route('image-upload')
])

<script>
    $(document).ready(function () {
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
</script>
@endpush
