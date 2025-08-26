@extends('frontend.layout.master')
@section('title')
    Transaksi | Payroll
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Transaksi Gaji</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <div class="col-md-auto mb-2">
                                <form action="{{ route('payrolls.generatePeriod') }}" method="POST"
                                    onsubmit="showLoading(this)">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg shadow-sm btn-block generate-btn">
                                        <i class="fas fa-sync-alt"></i> Tambah Periode Gaji
                                    </button>
                                </form>
                            </div>

                            <!-- Tombol Filter Data -->
                            <div class="col-md-auto mb-2">
                                <form action="{{ route('payrolls.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="month" name="filteringMonth"
                                            class="form-control form-control-lg shadow-sm"
                                            value="{{ request('filteringMonth', '2025-08') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info btn-lg shadow-sm" type="submit">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                                <form id="searchForm" action="{{ route('payrolls.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="payrollTableContainer">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            Periode Gaji
                                        </th>
                                        <th>Tanggal Buat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataPayrollPeriod->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <span class="badge badge-danger">Tidak ada data transaksi</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataPayrollPeriod as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ $dataPayrollPeriod->perPage() * ($dataPayrollPeriod->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->month_period)->translatedFormat('F Y') }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <a class="btn btn-info btn-sm"
                                                                href="{{ route('payrolls.show', Crypt::encrypt($item->id)) }}">
                                                                <i class="fas fa-eye"></i> Show</a>
                                                        </div>
                                                        <div class="p-1">
                                                            <a href="{{ route('payrolls.report_gaji', Crypt::encrypt($item->id)) }}"
                                                                class="btn btn-primary btn-sm" target="_blank">
                                                                <i class="fas fa-file-alt"></i> Cetak Laporan
                                                            </a>
                                                        </div>
                                                        <div class="p-1">
                                                            <form
                                                                action="{{ route('payrolls.destroy', Crypt::encrypt($item->id)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-button"
                                                                    data-id-order="{{ encrypt($item->id) }}">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $dataPayrollPeriod->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@section('script')
    @include('transaksi.payrolls.components.script_payrolls')
    <script>
        function showLoading(form) {
            let button = form.querySelector(".generate-btn");
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            button.disabled = true; // Menonaktifkan tombol
        }
    </script>
@endsection
@endsection
