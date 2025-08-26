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
            <h2 class="section-title">Form Add Order</h2>
            <p class="section-lead">Silakan isi form sesuai dengan kebutuhan di masing-masing tab...</p>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="formTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="order-tab" data-bs-toggle="tab" href="#order"
                                            role="tab" aria-controls="order" aria-selected="true">Data Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment"
                                            role="tab" aria-controls="order" aria-selected="true">Pembayaran</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="send-tab" data-bs-toggle="tab" href="#send_kurir"
                                            role="tab" aria-controls="order" aria-selected="true">Pengiriman</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="transaction-tab" data-bs-toggle="tab" href="#transaction"
                                            role="tab" aria-controls="transaction" aria-selected="false">Transaction</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="formTabsContent">
                                    <!-- Data Order Tab -->
                                    <div class="tab-pane fade show active" id="order" role="tabpanel"
                                        aria-labelledby="order-tab">
                                        <div class="section-title mt-0">Data Order</div>
                                        <div class="container">
                                            @include('transaksi.order.components.add_order.form_order_add')
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-primary" id="toPaymentTab">
                                                Next <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- Data Payment --}}
                                    <div class="tab-pane fade show" id="payment" role="tabpanel"
                                        aria-labelledby="payment-tab">
                                        <div class="section-title mt-0">Pembayaran</div>
                                        <div class="container">
                                            @include('transaksi.order.components.add_order.form_order_payment')
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-secondary" id="toOrderTab">
                                                <i class="fas fa-arrow-left"></i> Back
                                            </button>
                                            <div>
                                                <button type="button" class="btn btn-primary" id="toSenderTab">
                                                    Next <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show" id="send_kurir" role="tabpanel"
                                        aria-labelledby="send-tab">
                                        <div class="section-title mt-0">Pengiriman</div>
                                        <div class="container">
                                            @include('transaksi.order.components.add_order.form_order_send')
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-secondary" id="toPaymentTabBackTwo">
                                                <i class="fas fa-arrow-left"></i> Back
                                            </button>
                                            <div>
                                                <button type="button" class="btn btn-primary" id="toTransactionTab">
                                                    Next <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transaction Tab -->
                                    <div class="tab-pane fade" id="transaction" role="tabpanel"
                                        aria-labelledby="transaction-tab">
                                        <div class="section-title mt-0">Transaction</div>
                                        <div class="table-responsive">
                                            @include('transaksi.order.components.add_order.form_transaksi_order')
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <button type="button" class="btn btn-secondary" id="toSendTabBack">
                                                <i class="fas fa-arrow-left"></i> Back
                                            </button>
                                            <div>
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>

@section('script')
    <script>
        // Navigasi menggunakan tombol
        document.getElementById('toPaymentTab').addEventListener('click', function() {
            const paymentTab = new bootstrap.Tab(document.getElementById('payment-tab'));
            paymentTab.show();
        });
        document.getElementById('toSenderTab').addEventListener('click', function() {
            const paymentTab = new bootstrap.Tab(document.getElementById('send-tab'));
            paymentTab.show();
        });

        document.getElementById('toPaymentTabBackTwo').addEventListener('click', function() {
            const paymentTab = new bootstrap.Tab(document.getElementById('payment-tab'));
            paymentTab.show();
        });

        document.getElementById('toSendTabBack').addEventListener('click', function() {
            const paymentTab = new bootstrap.Tab(document.getElementById('send-tab'));
            paymentTab.show();
        });

        document.getElementById('toTransactionTab').addEventListener('click', function() {
            const transactionTab = new bootstrap.Tab(document.getElementById('transaction-tab'));
            transactionTab.show();
        });

        document.getElementById('toOrderTab').addEventListener('click', function() {
            const orderTab = new bootstrap.Tab(document.getElementById('order-tab'));
            orderTab.show();
        });

        // Bootstrap bawaan untuk navigasi tab tetap aktif
        const triggerTabList = [].slice.call(document.querySelectorAll('#formTabs a'));
        triggerTabList.forEach(function(triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    </script>
    @include('transaksi.order.components.script.script_add')
@endsection
@endsection
