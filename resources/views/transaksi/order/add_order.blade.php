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
                    <form action="">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title mt-0">Data Order</div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Company Type</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-building"></i>
                                                        </div>
                                                    </div>
                                                    <select name="" id="" class="form-control select2">
                                                        <option>Select option</option>
                                                        <option value="Individual">Individual</option>
                                                        <option value="Company">Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Order Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="date" name="" id=""
                                                        class="form-control datepicker">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Invoice Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah Hari</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="far fa-calendar-check"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" min="1" name="" id=""
                                                        class="form-control" placeholder="Ketik jumlah hari">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Pasang</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="date" name="" id=""
                                                        class="form-control datepicker">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Uang Muka (DP)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Nama Customer</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Number Phone</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-mobile-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" min="1" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Deliver Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Start event</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                            <input type="date" name="" id=""
                                                                class="form-control datepicker">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>End event</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                            <input type="date" name="" id=""
                                                                class="form-control datepicker">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Discount</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" name="" id=""
                                                        class="form-control">
                                                </div>
                                            </div>
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
                                    <table class="table table-hover table-bordered table-md">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Descriptions</th>
                                                <th>Days</th>
                                                <th>Quantity</th>
                                                <th>Jenis Satuan</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah Harga</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    <input type="text" name="" id=""
                                                        placeholder="Ketik produk">
                                                </td>
                                                <td>
                                                    <input type="text" name="" id=""
                                                        placeholder="Ketik Deskripsi">
                                                </td>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        placeholder="Hari">
                                                </td>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        placeholder="Quantity">
                                                </td>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        placeholder="Jenis Satuan">
                                                </td>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        placeholder="Ketik harga">
                                                </td>
                                                <td>
                                                    <input type="number" name="" id=""
                                                        placeholder="Jumlah Harga">
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-2">
                                                            <a href="#" class="btn btn-success"><i
                                                                    class="fas fa-plus-circle"></i></a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="#" class="btn btn-danger"><i
                                                                    class="fas fa-minus-circle"></i></a>
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
            </form>
            </div>
        </section>
    </section>

    {{-- @include('master.product.components.modal_add_product')
    @include('master.product.components.modal_edit_product') --}}


@section('script')
    <script>
        $(document).on('click', '.productUpdate', function() {
            var _this = $(this).parents('tr');
            var salesPriceText = _this.find('.sales_price').text();
            var salesPriceNumber = parseFloat(
                salesPriceText); // atau parseInt(salesPriceText) jika ingin nilai bulat
            $('#e_inter_ref').val(_this.find('.inter_ref').text());
            $('#e_name_product').val(_this.find('.name_product').text());
            $('#e_sales_price').val(salesPriceNumber);;
            $('#e_unit_measure').val(_this.find('.unit_measure').text());
        });
    </script>
    {{-- @include('master.product.components.script') --}}
@endsection
@endsection
