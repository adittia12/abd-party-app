@extends('frontend.layout.master')
@section('title')
    Transaksi | Detail Transaksi Keuangan
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Detail Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('operational.index') }}">Data Operasional INOUT</a>
                </div>
                <div class="breadcrumb-item">Detail Operational</div>
            </div>
        </div>

        <section class="section-body">
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="id" value="{{ Crypt::encrypt($operational->id) }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-title mt-0">Edit Operasional :
                                <b>{{ $operational->name_operational }}</b>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Operasional</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white">
                                                        <i class="fas fa-building"></i>
                                                    </span>
                                                </div>
                                                <span
                                                    class="form-control border rounded bg-light">{{ $operational->name_operational }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Operasional</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-success text-white">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <span class="form-control border rounded bg-light">
                                                    {{ \Carbon\Carbon::parse($operational->tgl_opartional)->translatedFormat('d F Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Uang Masuk</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-warning text-dark">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </span>
                                                </div>
                                                <span class="form-control border rounded bg-light"
                                                    id="budgetValue">{{ number_format($operational->budget, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Waktu Transaksi</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </div>
                                                <span
                                                    class="form-control border rounded bg-light font-weight-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($operational->time_date)->format('H:i:s') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                @if ($transOperational->isNotEmpty())
                                    <table class="table table-hover table-striped table-bordered shadow-sm rounded"
                                        id="table-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Nama Pegawai</th>
                                                <th class="text-right">Pengeluaran (Rp)</th>
                                                <th>Jenis</th>
                                            </tr>
                                        </thead>
                                        <tbody id="transactionBody">
                                            @php $totalNominal = 0; @endphp
                                            @foreach ($transOperational as $key => $operational)
                                                <tr>
                                                    <td class="text-center font-weight-bold">{{ $key + 1 }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-primary">{{ $operational->name_group }}</span>
                                                        {{ $operational->employee_name }}
                                                    </td>
                                                    <td class="text-right expend-value">
                                                        {{ number_format($operational->expend, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-info">{{ $operational->list_budget }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr class="font-weight-bold">
                                                <td colspan="2" class="text-right">Total Pengeluaran</td>
                                                <td class="text-right text-danger" id="totalExpend">Rp 0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="font-weight-bold">
                                                <td colspan="2" class="text-right">Budget</td>
                                                <td class="text-right text-success" id="displayBudget">Rp 0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="font-weight-bold">
                                                <td colspan="2" class="text-right">Sisa Pemasukkan</td>
                                                <td class="text-right text-primary" id="remainingIncome">Rp 0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <div class="alert alert-danger text-center font-weight-bold">
                                        <i class="fas fa-exclamation-triangle"></i> Tidak ada transaksi
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection


@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalExpend = 0;

            // Ambil budget dari elemen HTML
            let budgetText = document.getElementById("budgetValue").innerText;
            let budget = parseInt(budgetText.replace(/\./g, "")) || 0; // Hapus titik agar bisa diubah jadi angka

            // Hitung total pengeluaran
            document.querySelectorAll(".expend-value").forEach(function(el) {
                let value = parseInt(el.innerText.replace(/\./g, "")) || 0;
                totalExpend += value;
            });

            let remainingIncome = budget - totalExpend;

            // Tampilkan hasil di tabel
            document.getElementById("totalExpend").innerText = formatCurrency(totalExpend);
            document.getElementById("displayBudget").innerText = formatCurrency(budget);
            document.getElementById("remainingIncome").innerText = formatCurrency(remainingIncome);
        });

        function formatCurrency(amount) {
            return "Rp " + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
@endsection
