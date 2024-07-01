@extends('frontend.layout.master')

@section('title')
    Dashboard | ABD
@endsection

@section('header')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="d-flex flex-row">
                            <div class="p-1">
                                @include('home.components.filter.filter_month')
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <div class="p-1">
                                <strong>Welcome, {{ Auth::user()->name }}</strong>
                                <p>{{ $todayDate }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-row-reverse">
                            @include('home.components.filter.filter_year')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('home.components.alert.alert_dashboard')
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admin</h4>
                        </div>
                        <div class="card-body">
                            10
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Barang Rental</h4>
                        </div>
                        <div class="card-body">
                            {{ $productCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reports</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Online Users</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Realisasi Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="transactionsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Status Order</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="doughnut-order"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Overview</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Order</th>
                                    <th>Tanggal Acara</th>
                                    <th>Status Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overviewOrder as $item)
                                    <tr>
                                        <td>{{ $item->order_number }}</td>
                                        <td>{{ $item->start_event }}</td>
                                        <td>
                                            @if ($item->status_order == 'Pengajuan')
                                                <span class="badge badge-secondary">{{ $item->status_order }}</span>
                                            @elseif ($item->status_order == 'Sudah Ok')
                                                <span class="badge badge-info">{{ $item->status_order }}</span>
                                            @elseif ($item->status_order == 'Order Cancel')
                                                <span class="badge badge-danger">{{ $item->status_order }}</span>
                                            @elseif ($item->status_order == 'Invoice')
                                                <span class="badge badge-success">{{ $item->status_order }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@section('script')
    @include('home.components.script.script')
@endsection
@endsection
