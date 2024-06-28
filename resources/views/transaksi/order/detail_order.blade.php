@extends('frontend.layout.master')
@section('title')
    Transaksi | Detail Order
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Detail Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('order.index') }}">List Order</a></div>
                <div class="breadcrumb-item">Detail Order</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Detail order</h2>
            <p class="section-lead">Berikut detail order</p>
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="id" value="{{ Crypt::encrypt($order->id) }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-title mt-0">Edit Order : <b>{{ $order->order_number }}</b></div>
                            <div class="container">
                                @include('transaksi.order.components.detail_order.form_detail_order')
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                <div class="p-2">
                                    @if ($order->status_order == 'Sudah Ok' || $order->status_order == 'Invoice')
                                        <a href="{{ route('order.cetak_order', $order->id) }}" class="btn btn-primary"
                                            target="_blank">Cetak Order/Transaksi</a>
                                    @elseif ($order->status_order == 'Order Cancel')
                                        <span class="badge badge-danger">{{ $order->status_order }}</span>
                                    @endif
                                </div>
                                @if ($order->status_order == 'Invoice')
                                    <div class="p-2">
                                        <a href="{{ route('order.cetak_invoice', Crypt::encrypt($order->id)) }}"
                                            class="btn btn-danger" target="_blank"><i class="fas fa-print"></i>
                                            Invoice</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('transaksi.order.components.detail_order.form_transaksi_order_detail')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </section>
@endsection
