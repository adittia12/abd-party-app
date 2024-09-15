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
                        <div class="d-flex justify-content-between mb-3">
                            <!-- Dropdown di Kiri -->
                            <div class="p-2">
                                <select id="perPageSelect" name="per_page" class="form-control">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <!-- Form Pencarian di Kanan -->
                            <div class="p-2">
                                <form id="searchForm" action="{{ route('product.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="productTableContainer">
                            <table class="table table-striped table-hover">
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
                                            <td>{{ $product->perPage() * ($product->currentPage() - 1) + $key + 1 }}</td>
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
                            {{ $product->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('master.product.components.modal_add_product')
    @include('master.product.components.modal_edit_product')


@section('script')
    @include('master.product.components.script')
@endsection
@endsection
