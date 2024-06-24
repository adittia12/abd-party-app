@extends('frontend.layout.master')
@section('title')
    Master | Product
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Product</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">List Data Product</h3>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#add_product"><i class="fa fa-plus"></i> Add Product</button>
                            </div>
                        </div>
                    </div>
                    @include('sweetalert::alert')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Product</th>
                                        <th>Name Product</th>
                                        {{-- <th></th> --}}
                                        <th>Sales Price</th>
                                        <th>Unit Measure</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="inter_ref">{{ $item->inter_ref }}</td>
                                            <td class="name_product">{{ $item->name_product }}</td>
                                            <td class="sales_price">{{ $item->sales_price }}</td>
                                            <td class="unit_measure">{{ $item->unit_measure }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        More Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item productUpdate" data-toggle="modal"
                                                                data-id="'.$item->id.'" data-target="#edit_product"><i
                                                                    class="fas fa-pen-square"></i> Edit</a></li>
                                                        <form action="{{ route('product.destroy', $item->inter_ref) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li><a class="dropdown-item delete-button"
                                                                    data-id="{{ $item->inter_ref }}"><i
                                                                        class="fas fa-trash"></i>
                                                                    Delete</a></li>
                                                        </form>
                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('master.product.components.modal_add_product')
    @include('master.product.components.modal_edit_product')


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
    @include('master.product.components.script')
@endsection
@endsection
