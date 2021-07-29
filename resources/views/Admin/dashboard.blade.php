@php
    use App\Models\Cadastros\Clientes;
    use App\Models\Cadastros\Veiculos;
    use App\Models\Cadastros\Motoristas;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.dashboard'))

@section('content')
    @if (Session::get('login-success')) 
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span>{{ Session::get('login-success') }}</span>
            </div>
        </div>
    @endif

    
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-purple">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{ Clientes::count() }}</h2>
                            <p class="m-b-0 text-muted">@lang('labels.clientes')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-usergroup-add"></i>
                        </div>
                        <div class="m-l-15">
                            {{-- <h2 class="m-b-0">{{ Motoristas::count() }}</h2> --}}
                            <p class="m-b-0 text-muted">@lang('labels.motoristas')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-car"></i>
                        </div>
                        <div class="m-l-15">
                            {{-- <h2 class="m-b-0">{{ Veiculos::count() }}</h2> --}}
                            <p class="m-b-0 text-muted">@lang('labels.veiculos')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-gold">
                            <i class="anticon anticon-profile"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0"></h2>
                            <p class="m-b-0 text-muted">@lang('labels.coletas')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    {{-- <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Top Product</h5>
                        <div>
                            <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Sales</th>
                                        <th>Earning</th>
                                        <th style="max-width: 70px">Stock Left</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-image rounded">
                                                    <img src="assets/images/others/thumb-9.jpg" alt="">
                                                </div>
                                                <div class="m-l-10">
                                                    <span>Gray Sofa</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>81</td>
                                        <td>$1,912.00</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-sm w-100 m-b-0">
                                                    <div class="progress-bar bg-success" style="width: 82%"></div>
                                                </div>
                                                <div class="m-l-10">
                                                    82
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-image rounded">
                                                    <img src="assets/images/others/thumb-10.jpg" alt="">
                                                </div>
                                                <div class="m-l-10">
                                                    <span>Gray Sofa</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>26</td>
                                        <td>$1,377.00</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-sm w-100 m-b-0">
                                                    <div class="progress-bar bg-success" style="width: 61%"></div>
                                                </div>
                                                <div class="m-l-10">
                                                    61
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-image rounded">
                                                    <img src="assets/images/others/thumb-11.jpg" alt="">
                                                </div>
                                                <div class="m-l-10">
                                                    <span>Wooden Rhino</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>71</td>
                                        <td>$9,212.00</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-sm w-100 m-b-0">
                                                    <div class="progress-bar bg-danger" style="width: 23%"></div>
                                                </div>
                                                <div class="m-l-10">
                                                    23
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-image rounded">
                                                    <img src="assets/images/others/thumb-12.jpg" alt="">
                                                </div>
                                                <div class="m-l-10">
                                                    <span>Red Chair</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>79</td>
                                        <td>$1,298.00</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-sm w-100 m-b-0">
                                                    <div class="progress-bar bg-warning" style="width: 54%"></div>
                                                </div>
                                                <div class="m-l-10">
                                                    54
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-image rounded">
                                                    <img src="assets/images/others/thumb-13.jpg" alt="">
                                                </div>
                                                <div class="m-l-10">
                                                    <span>Wristband</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>60</td>
                                        <td>$7,376.00</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-sm w-100 m-b-0">
                                                    <div class="progress-bar bg-success" style="width: 76%"></div>
                                                </div>
                                                <div class="m-l-10">
                                                    76
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection