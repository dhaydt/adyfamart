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

    <div class="card mb-4">
        <div class="card-body" style="padding-bottom: 12px">
            <div class="row flex-between mx-1">
                @php($config=\App\CPU\Helpers::get_business_settings('maintenance_mode'))
                <div class="flex-between">
                    <h5 class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"><i
                            class="tio-settings-outlined"></i></h5>
                    <h5>{{\App\CPU\translate('Cut_Off_Transactions')}}</h5>
                </div>
                <div>
                    <label
                        class="switch ml-3 float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                        <input type="checkbox" class="status" onclick="maintenance_mode()"
                            {{isset($config) && $config?'checked':''}}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{\App\CPU\translate('Mitra')}} {{\App\CPU\translate('Settings')}} </h4>
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
        @php($periodes = \App\Periode::orderBy('created_at', 'desc')->get())
        <div class="col-md-6">
            <div class="card-header d-flex justify-content-between">
                <h5>{{\App\CPU\translate('Order_periode')}}</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-plus"></i> Periode
                </button>
            </div>
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <div class="table-responsive">
                        <table id="columnSearchDatatable" style="text-align: left;"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if (count($periodes) > 0)
                                @foreach ($periodes as $key => $periode)
                                <tr>
                                    <td>
                                        {{ $periode->name }}
                                    </td>
                                    <td>
                                        <label class="switch switch-status">
                                            <input type="checkbox" class="status" id="{{$periode['id']}}"
                                                onclick="statusChange({{$periode->id}}, this.value)" {{ $periode->status
                                            == 1?'checked':''}} value="{{ $periode->status }}">
                                            <span class="slider round"></span>
                                        </label>
                                        <label class="ml-3" for="status-{{ $periode->id }}">
                                            @if ($periode->status == 1)
                                            Active
                                            @else
                                            Disabled
                                            @endif
                                        </label>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Tidak ada data periode
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formPeriode" action="{{ route('admin.business-settings.periode.update') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Periode Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kode Periode</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="status" value="0" onclick="changeStatus(this.value)"
                                        class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1" id="status">Non
                                        Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
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
    function statusChange(id, value){
        console.log('val', id, value);
        Swal.fire({
                title: '{{\App\CPU\translate('Are you sure to change status')}}?',
                text: '',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {

                var data = {
                    id: id,
                    val: value
                }

                var json = JSON.stringify(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.business-settings.periode.status')}}',
                    data: json,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            if(data == 'success'){
                                toastr.success('{{\App\CPU\translate('Status changed successfully')}}!', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                                location.reload();
                            }else{
                                toastr.warning('{{\App\CPU\translate('all statuses cant be turned off')}}!', {
                                    CloseButton: true,
                                });
                                location.reload();
                            }
                        }
                    }
                });
            })
    }
    function changeStatus(val){
        if(val == 0){
            $('input[name=status]').val(1);
            $('#status').text('Active');
        }else{
            $('input[name=status]').val(0);
            $('#status').text('Non Active');
        }
    }
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
    function maintenance_mode() {
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure')}}?',
                text: '{{\App\CPU\translate('cut off transactions will cut off the user transaction process!')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('admin.maintenance-mode')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
        };

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
