@extends('frontend.layout.master')
@section('title')
    Transaksi | Order
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Transaksi Order</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">Order list</h3>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="{{ route('order.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add
                                    Order</a>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="{{ route('export_transaksi', ['filteringMonth' => $filterMonth]) }}"
                                    class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Download Laporan
                                </a>
                            </div>
                            <div class="col-auto float-left mr-auto">
                                <div class="d-flex flex-row">
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#filterData">
                                        Filter Data
                                    </button>
                                </div>
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
                                <form id="searchForm" action="{{ route('order.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="orderTableContainer">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode order</th>
                                        <th>Order Date</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal Pasang</th>
                                        <th>Mulai Acara</th>
                                        <th>Status Order</th>
                                        <th>Sisa Tagihan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderData as $key => $item)
                                        <tr>
                                            <td>
                                                {{ $orderData->perPage() * ($orderData->currentPage() - 1) + $key + 1 }}
                                            </td>
                                            <td class="order_number">{{ $item->order_number }}</td>
                                            <td class="order_date">
                                                {{ \Carbon\Carbon::parse($item->tgl_order)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="name_customer">{{ $item->name_customer }}</td>
                                            <td class="date_pasang">
                                                {{ \Carbon\Carbon::parse($item->date_pasang)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="start_event">
                                                {{ \Carbon\Carbon::parse($item->start_event)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="status_order">
                                                @if ($item->status_order === 'Pengajuan')
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span
                                                                class="badge badge-secondary">{{ $item->status_order }}</span>
                                                        </div>
                                                        @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
                                                            <div class="p-1">
                                                                <form action="{{ route('order.approve_ok') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="order_id"
                                                                        value="{{ $item->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm rounded-full">Approve</button>
                                                                </form>
                                                            </div>
                                                            <div class="p-1">
                                                                <form action="{{ route('order.approve_cancel') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="order_id_cancel"
                                                                        value="{{ $item->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm rounded-full">Cancel</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif ($item->status_order === 'Order Cancel')
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span
                                                                class="badge badge-danger">{{ $item->status_order }}</span>
                                                        </div>
                                                    </div>
                                                @elseif ($item->status_order === 'Sudah Ok')
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span
                                                                class="badge badge-primary">{{ $item->status_order }}</span>
                                                        </div>
                                                        @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
                                                            <div class="p-2">
                                                                <form action="{{ route('order.approve_invoice') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="order_id_invoice"
                                                                        value="{{ $item->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm rounded-full">Approve</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif ($item->status_order === 'Invoice')
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span class="badge badge-info">{{ $item->status_order }}</span>
                                                        </div>
                                                        @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
                                                            <div class="p-1">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm rounded-full"
                                                                    data-toggle="modal" data-target="#billPayment"
                                                                    data-payment-id="{{ $item->id }}">
                                                                    Tagihan
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif ($item->status_order === 'Lunas')
                                                    <span class="badge badge-success">{{ $item->status_order }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->sisa_tagihan)
                                                    {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                                @elseif ($item->sisa_tagihan == 0)
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span class="badge badge-success">Sudah Lunas</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="p-1">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-info dropdown-toggle btn-sm"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                More Action
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('order.show', Crypt::encrypt($item->id)) }}"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Detail</a></li>
                                                                @if (
                                                                    $item->status_order === 'Pengajuan' ||
                                                                        $item->status_order === 'Sudah Ok' ||
                                                                        ($item->status_order == 'Invoice' && Auth::user()->role_name == 'Super Admin'))
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('order.edit', $item->id) }}"><i
                                                                                class="fas fa-pen-square"></i>
                                                                            Edit</a></li>
                                                                @elseif ($item->status_order == 'Order Cancel' && Auth::user()->role_name == 'Super Admin')
                                                                    <li><a class="dropdown-item" href="#"
                                                                            @disabled(true)><i
                                                                                class="fas fa-pen-square"></i>
                                                                            Edit</a></li>
                                                                @elseif (Auth::user()->role_name == 'Admin')
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('order.edit', $item->id) }}"><i
                                                                                class="fas fa-pen-square"></i>
                                                                            Edit</a></li>
                                                                @endif
                                                                <form action="{{ route('order.destroy', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <li><a type="button"
                                                                            class="dropdown-item delete-button"
                                                                            data-id-order="{{ $item->id }}"><i
                                                                                class="fas fa-trash"></i>
                                                                            Delete</a></li>
                                                                </form>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $orderData->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('transaksi.order.components.modal_filter')
    @include('transaksi.order.components.modal_bill_payment')
@section('script')
    @include('transaksi.order.components.script_order')
@endsection
@endsection
