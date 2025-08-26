@extends('frontend.layout.master')

@section('title')
    Detail Periode Payroll
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h5>Periode Gaji <span
                    class="text-primary">{{ \Carbon\Carbon::parse($dataPayrollPeriod->month_period)->translatedFormat('F Y') }}</span>
            </h5>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('payrolls.index') }}">Payroll</a></div>
                <div class="breadcrumb-item active">Detail Periode</div>
            </div>
        </div>
        @include('sweetalert::alert')
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <a href="{{ route('payrolls.create', Crypt::encrypt($dataPayrollPeriod->id)) }}"
                    class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
                <div class="card-header-action">
                    <a href="{{ route('payrolls.index') }}" class="btn btn-info btn-sm shadow-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($transPayroll->isEmpty())
                    <div class="alert alert-warning text-center shadow-sm">
                        <i class="fas fa-exclamation-triangle"></i>
                        Tidak ada data transaksi payroll untuk periode ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table-1">
                            <thead class="bg-primary text-white-all">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th><i class="fas fa-user"></i> Nama Karyawan</th>
                                    <th><i class="fas fa-users"></i> Nama Grup</th>
                                    <th><i class="fas fa-calendar"></i> Periode Gaji</th>
                                    <th><i class="fas fa-clock"></i> Jenis Gaji</th>
                                    <th><i class="fas fa-clock"></i> Tanggal Input</th>
                                    <th><i class="fas fa-pen"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transPayroll as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $item->name_employe }}</td>
                                        <td>{{ $item->name_group }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->month_period)->translatedFormat('F Y') }}</td>
                                        <td>
                                            {{ $item->list_payroll ?? 'Belum pilih Jenis' }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}
                                        </td>
                                        <td class="text-center">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('payrolls.edit_payroll', [Crypt::encrypt($item->id_periode_pay), Crypt::encrypt($item->id_trans_pay)]) }}"
                                                class="btn btn-warning btn-sm shadow-sm me-1">
                                                <i class="fas fa-edit"></i> Ubah
                                            </a>


                                            {{-- Tombol Document --}}
                                            <a href="{{ route('payrolls.cetak_slip', ['periode' => encrypt($item->id_periode_pay), 'idTransPay' => encrypt($item->id_trans_pay)]) }}"
                                                class="btn btn-info btn-sm shadow-sm me-1" target="_blank">
                                                <i class="fas fa-file-alt"></i> Slip
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form
                                                action="{{ route('payrolls.delete_pay', Crypt::encrypt($item->id_trans_pay)) }}"
                                                method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-button"
                                                    data-id="{{ Crypt::encrypt($item->id_trans_pay) }}">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Tambahkan event listener untuk tombol "Delete"
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach((button) => {
                button.addEventListener('click', function() {
                    const id = button.getAttribute('data-id');
                    Swal.fire({
                        title: 'Delete Confirmation',
                        text: 'Apakah kamu yakin akan menghapus nya ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                            const form = document.createElement('form');
                            form.setAttribute('action',
                                "{{ route('payrolls.delete_pay', '') }}" + '/' + id);
                            form.setAttribute('method', 'POST');
                            form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
