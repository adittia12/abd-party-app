@extends('frontend.layout.master')
@section('title')
    Transaksi | Add Order
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Add Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('order.index') }}">List Order</a></div>
                <div class="breadcrumb-item">Add Order</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Form order</h2>
            <p class="section-lead">Silakan isi form sesuai dengan kebutuhan...</p>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title mt-0">Data Order</div>
                                <div class="container">
                                    @include('transaksi.order.components.add_order.form_order_add')
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-2">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                        </div>
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Transaction</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('transaksi.order.components.add_order.form_transaksi_order')
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>




@section('script')
    @include('transaksi.order.components.script.script_add')
@endsection
@endsection
