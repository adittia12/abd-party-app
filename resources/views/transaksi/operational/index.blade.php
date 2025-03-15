@extends('frontend.layout.master')
@section('title')
    Transaksi | Operasional
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Transaksi Operasional</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center justify-content-between">
                            <!-- Tombol Tambah Data -->
                            <div class="col-md-auto mb-2">
                                <a href="{{ route('operational.create') }}"
                                    class="btn btn-success btn-lg shadow-sm btn-block">
                                    <i class="fas fa-plus-circle"></i> Tambah Transaksi
                                </a>
                            </div>

                            <!-- Tombol Generate Sisa Budget dengan Animasi Loading -->
                            <div class="col-md-auto mb-2">
                                <form action="{{ route('operational.generateBudget') }}" method="POST"
                                    onsubmit="showLoading(this)">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-lg shadow-sm btn-block generate-btn">
                                        <i class="fas fa-sync-alt"></i> Generate Sisa Budget
                                    </button>
                                </form>
                            </div>

                            <!-- Tombol Filter Data -->
                            <div class="col-md-auto mb-2">
                                <button type="button" class="btn btn-outline-info btn-lg shadow-sm btn-block"
                                    data-toggle="modal" data-target="#filterData">
                                    <i class="fas fa-filter"></i> Filter Data
                                </button>
                            </div>
                            <div class="col-md-auto mb-2">
                                <button type="button" class="btn btn-outline-danger btn-lg shadow-sm btn-block"
                                    data-toggle="modal" data-target="#report_operational">
                                    <i class="fas fa-print"></i> Cetak Laporan
                                </button>
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
                                <form id="searchForm" action="{{ route('operational.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="operationalTableContainer">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'tgl_opartional',
                                                    'order' => request('order', 'desc') === 'desc' ? 'asc' : 'desc',
                                                ]) }}">
                                                Tanggal
                                                @if (request('sort_by', 'tgl_opartional') == 'tgl_opartional')
                                                    {!! request('order', 'desc') == 'desc' ? '↓' : '↑' !!}
                                                @endif
                                            </a>
                                        </th>
                                        <th>Deskripsi</th>
                                        <th>
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'budget', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}">
                                                Budget {!! request('sort_by') == 'budget' ? (request('order') == 'asc' ? '↑' : '↓') : '' !!}
                                            </a>
                                        </th>
                                        <th>Sisa Budget</th>
                                        <th>Waktu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataOperational->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <span class="badge badge-danger">Tidak ada data transaksi</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataOperational as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ $dataOperational->perPage() * ($dataOperational->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->tgl_opartional)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $item->name_operational }}</td>
                                                <td>{{ number_format($item->budget, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($item->remainingBudget)
                                                        <b>{{ number_format($item->remainingBudget, 0, ',', '.') }}</b>
                                                    @elseif ($item->remainingBudget == 0)
                                                        <div class="d-flex justify-content-center">
                                                            <div class="p-1">
                                                                <span class="badge badge-success">Sudah terpakai</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <b
                                                            class="text-red">{{ number_format($item->remainingBudget, 0, ',', '.') }}</b>
                                                    @endif
                                                </td>
                                                <td>{{ $item->time_date }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-1">
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-outline-info btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                    More Action
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-right">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('operational.show', Crypt::encrypt($item->id)) }}">
                                                                            <i class="fas fa-info-circle"></i> Detail</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('operational.edit', $item->id) }}">
                                                                            <i class="fas fa-pen-square"></i> Edit</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="p-1">
                                                            <form
                                                                action="{{ route('operational.destroy', Crypt::encrypt($item->id)) }}"
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
                            {{ $dataOperational->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('transaksi.operational.components.modal_filter')
    @include('transaksi.operational.components.modal_export_pdf')
@section('script')
    @include('transaksi.operational.components.script_operational')
    <script>
        function showLoading(form) {
            let button = form.querySelector(".generate-btn");
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            button.disabled = true; // Menonaktifkan tombol
        }
    </script>
@endsection
@endsection
