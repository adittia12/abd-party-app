@extends('frontend.layout.master')
@section('title')
    Trans Operasional | Edit
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Edit Operasional</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('operational.index') }}">List Operasional</a></div>
                <div class="breadcrumb-item">Edit Transaksi</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Form Operasional</h2>
            <p class="section-lead">Silakan lakukan edit jika ada yang perlu diubah...</p>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('operational.update_operational') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_operational_trans" value="{{ $operational->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title mt-0">Edit Operasional :
                                    <b>{{ $operational->code_operational }}</b>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tanggal Operasional</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="date" name="tgl_opartional" id="tgl_opartional"
                                                        value="{{ $operational->tgl_opartional }}" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Operasional (Deskripsi)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-align-justify"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="name_operational" id="name_operational"
                                                        value="{{ $operational->name_operational }}"
                                                        class="form-control @error('name_operational') @enderror">
                                                </div>
                                                @if ($errors->has('name_operational'))
                                                    <span
                                                        class="text-danger text-sm">{{ $errors->first('name_operational') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Budget (In)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" name="budget" id="budgetInput"
                                                        value="{{ $operational->budget }}"
                                                        data-initial-budget="{{ $operational->budget }}"
                                                        class="form-control" readonly>

                                                </div>
                                                @if ($errors->has('budget'))
                                                    <span class="text-danger text-sm">{{ $errors->first('budget') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-2">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                        </div>
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Transaction</h4>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Add"
                                    id="addRow">Add Row</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="transactionTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Pegawai</th>
                                                <th>Jenis Pengeluaran/Pemasukkan</th>
                                                <th>Nominal</th>
                                                <th>Deskripsi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transOperational as $key => $transaksi)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <input type="hidden" name="id_operational_transaksi[]"
                                                            value="{{ $transaksi->id }}">
                                                        <select name="id_employe[]" id="id_employe"
                                                            class="transSearch form-control select2 @error('id_employe.*') is-invalid @enderror"
                                                            style="width: 100%">
                                                            <option value="{{ $transaksi->id_employe }}">
                                                                {{ $transaksi->employee_name }}
                                                                -
                                                                ({{ $transaksi->name_group }})
                                                            </option>
                                                            @foreach ($listEmploye as $employe)
                                                                <option value="{{ $employe->id }}">
                                                                    {{ $employe->name }}
                                                                    - ({{ $employe->name_group }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('id_employe.*'))
                                                            <span
                                                                class="text-danger text-sm">{{ $errors->first('id_employe.*') }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <select name="jenis_pemasukan[]" id="jenis_pemasukan"
                                                            class="select2 select-jenis @error('jenis_pemasukan.*') is-invalid @enderror"
                                                            style="width: 100%">
                                                            <option value="{{ $transaksi->id_list_budget }}">
                                                                {{ $transaksi->list_budget }}</option>
                                                            @foreach ($listBudget as $item)
                                                                <option value="{{ $item->id_jen_pemasuk }}">
                                                                    {{ $item->list_budget }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('jenis_pemasukan.*'))
                                                            <span
                                                                class="text-danger text-sm">{{ $errors->first('jenis_pemasukan.*') }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="position: relative;">
                                                        <!-- Input untuk angka mentah -->
                                                        <input type="number" name="expend[]"
                                                            class="form-control nominal-expend expend-input number-input"
                                                            value="{{ $transaksi->expend }}" placeholder="Nominal"
                                                            style="width: 70%; padding-right: 30px;" disabled>

                                                        <!-- Elemen overlay untuk menampilkan format Rupiah -->
                                                        <div class="formatted-text"
                                                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none; color: gray; font-size: 0.9em;">
                                                            <b>
                                                                {{ 'Rp ' . number_format($transaksi->expend, 0, ',', '.') }}
                                                            </b>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="description[]" id="description"
                                                            class="form-control @error('description.*') is-invalid @enderror"
                                                            value="{{ $transaksi->description }}"
                                                            placeholder="Deskripsi">
                                                        @if ($errors->has('description.*'))
                                                            <span
                                                                class="text-danger text-sm">{{ $errors->first('description.*') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-danger remove-trans btn-sm"
                                                            data-id="{{ $transaksi->id }}">Hapus</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>z
                                            <tr>
                                                <td colspan="2">Total Pengeluaran</td>
                                                <td id="totalExpend">Rp 0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Budget</td>
                                                <td id="displayBudget">Rp 0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Sisa Pemasukkan</td>
                                                <td id="remainingIncome" style="font-weight: bold;">Rp 0</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>




@section('script')
    @include('transaksi.operational.components.edit.script_edit_operasional')
@endsection
@endsection
