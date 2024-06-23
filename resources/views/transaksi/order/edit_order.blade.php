@extends('frontend.layout.master')
@section('title')
    Transaksi | Edit Order
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Add Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('order.index') }}">List Order</a></div>
                <div class="breadcrumb-item">Edit Order</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Form order</h2>
            <p class="section-lead">Silakan edit data order sebelum dilakukan approve invoice, jika sudah di click invoice
                data order tidak dapat dilakukan perubahan data kembali...</p>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('order.update_order_transaksi') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_order_trans" value="{{ $order->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title mt-0">Edit Order : <b>{{ $order->order_number }}</b></div>
                                <div class="container">
                                    @include('transaksi.order.components.edit_order.form_order_edit')
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-2">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                        </div>
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Transaction</h4>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Add"
                                    id="addBtn">Add Row</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('transaksi.order.components.edit_order.form_transaksi_order_edit')

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
    @include('transaksi.order.components.script.script_edit')
@endsection
@endsection
