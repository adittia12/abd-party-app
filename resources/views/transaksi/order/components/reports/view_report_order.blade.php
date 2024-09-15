@extends('frontend.layout.master')
@section('title')
    Transaksi | Laporan
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Laporan Tagihan</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col-auto float-right ml-auto">
                                <a href="{{ route('export_order', ['filteringMonth' => $filterMonth]) }}"
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
                                <form id="searchForm" action="{{ route('report_order.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="orderReportTableContainer">
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
                                                    </div>
                                                @elseif ($item->status_order === 'Invoice')
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <span class="badge badge-info">{{ $item->status_order }}</span>
                                                        </div>
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
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('report_order.show', Crypt::encrypt($item->id)) }}"><i
                                                        class="fas fa-info-circle"></i>
                                                    Detail</a>
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

    @include('transaksi.order.components.reports.modal_filter_data')
@section('script')
    @include('transaksi.order.components.reports.script_report')
@endsection
@endsection
