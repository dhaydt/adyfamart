@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Mitra Saldo List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Mitra_saldo')}}</li>
            </ol>
        </nav>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row row justify-content-between align-items-center flex-grow-1 mx-1">
                            <div class="flex-between">
                                <div><h5>{{\App\CPU\translate('mitra_saldo_table')}}</h5></div>
                                <div class="mx-1"><h5 style="color: red;">({{ $sellers->total() }})</h5></div>
                            </div>
                            <div style="width: 40vw">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\translate('Search by Name or Phone or Email')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{\App\CPU\translate('SL#')}}</th>
                                    <th scope="col">{{\App\CPU\translate('mitra_id')}}</th>
                                    <th scope="col">{{\App\CPU\translate('name')}}</th>
                                    <th scope="col">{{\App\CPU\translate('Phone')}}</th>
                                    <th scope="col">{{\App\CPU\translate('Email')}}</th>
                                    <th scope="col">{{\App\CPU\translate('Saldo')}}</th>
                                    <th scope="col" style="width: 50px">{{\App\CPU\translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sellers as $key=>$seller)
                                    <tr>
                                        <td scope="col">{{$sellers->firstItem()+$key}}</td>
                                        <td scope="col">
                                            {{ $seller->code_admin }}
                                        </td>
                                        <td scope="col">{{$seller->name}}</td>
                                        <td scope="col">{{$seller->phone}}</td>
                                        <td scope="col">{{$seller->email}}</td>
                                        <td scope="col">{{ number_format($seller->wallet ? $seller->wallet->saldo : '0') }}
                                        </td>
                                        <td>
                                            {{-- <a class="btn btn-primary"
                                               href="{{route('admin.sellers.view',$seller->id)}}">
                                                {{\App\CPU\translate('View')}}
                                            </a> --}}
                                            <button type="button" class="btn btn-primary" onclick="addSaldo({{ $seller }})" data-toggle="modal" data-target="#modalSaldo">
                                                Limit Saldo
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Modal Saldo --}}
                    <!-- Modal -->
                    <div class="modal fade" id="modalSaldo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Limit Saldo Mitra</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.saldo.add') }}" method="POST">
                                @csrf
                                <input type="hidden" id="id_admin" name="id_admin">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="id_admin">ID</label>
                                        <input type="text" id="code_admin" class="form-control" readonly name="code_admin">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_admin">Nama Mitra</label>
                                        <input type="text" id="name_mitra" class="form-control" readonly name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_admin">Limit Saldo Mitra</label>
                                        <input type="number" class="form-control" name="saldo">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan saldo</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! $sellers->links() !!}
                    </div>
                    @if(count($sellers)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function addSaldo(data){
            $('#id_admin').val(data.id)
            $('#name_mitra').val(data.name)
            $('#code_admin').val(data.code_admin)
            // $('#modalSaldo').modal('show');
        }
    </script>
@endpush
