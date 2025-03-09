@extends('frontend.layout.master')
@section('title')
    Transaksi | Add Trans
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Tambah Data Transaksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('operational.index') }}">Data Transaksi</a></div>
                <div class="breadcrumb-item">Add Trans</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Form Transaksi</h2>
            <p class="section-lead">Silakan isi form sesuai dengan kebutuhan...</p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('operational.store') }}" method="POST" onsubmit="showLoading(this)">
                                @csrf
                                <ul class="nav nav-tabs" id="formTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="operational-tab" data-toggle="tab"
                                            href="#operational" role="tab" aria-controls="operational"
                                            aria-selected="true">Data Operasional</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction"
                                            role="tab" aria-controls="transaction" aria-selected="false">Form
                                            Transaksi</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="formTabsContent">
                                    <!-- Tab 1 -->
                                    <div class="tab-pane fade show active" id="operational" role="tabpanel"
                                        aria-labelledby="operational-tab">
                                        <div class="row">
                                            <!-- Kolom Kiri -->
                                            <div class="col-md-6">
                                                <div class="form-group mt-3">
                                                    <label>Tanggal Operasional</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-calendar-alt"></i>
                                                            </div>
                                                        </div>
                                                        <input type="date" name="tgl_opartional" id="tgl_opartional"
                                                            class="form-control datepicker @error('tgl_opartional') is-invalid @enderror"
                                                            value="{{ old('tgl_opartional') }}">
                                                    </div>
                                                    @error('tgl_opartional')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Operasional</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-align-left"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="name_operational" id="name_operational"
                                                            class="form-control @error('name_operational') is-invalid @enderror"
                                                            value="{{ old('name_operational') }}">
                                                    </div>
                                                    @error('name_operational')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Kolom Kanan -->
                                            <div class="col-md-6">
                                                <div class="form-group mt-3">
                                                    <label>Budget</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="1" name="budget" id="budgetInput"
                                                            class="form-control @error('budget') is-invalid @enderror"
                                                            value="{{ old('budget') }}">
                                                    </div>
                                                    @error('budget')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 2 -->
                                    <div class="tab-pane fade" id="transaction" role="tabpanel"
                                        aria-labelledby="transaction-tab">
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col">
                                                    <button type="button" class="mb-3 btn btn-success"
                                                        id="addRow">Tambah
                                                        Baris</button>
                                                </div>
                                            </div>
                                            @include('transaksi.operational.components.add.form_transaksi_operational')
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit dengan Animasi Loading -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg save-btn">
                                        <i class="fas fa-save"></i> Simpan Transaksi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('script')
    @include('transaksi.operational.components.add.script_add_operational')
    <script>
        function showLoading(form) {
            let button = form.querySelector(".save-btn");
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Process Save...';
            button.disabled = true; // Menonaktifkan tombol
        }
    </script>
@endsection
