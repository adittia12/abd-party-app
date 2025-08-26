@extends('frontend.layout.master')
@section('title', 'Transaksi | Gaji')

@section('content')
    <section class="section">
        @include('sweetalert::alert')

        <div class="section-header">
            <h1>Tambah Gaji</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('payrolls.show', Crypt::encrypt($periode->id)) }}">Data Gaji</a>
                </div>
                <div class="breadcrumb-item">Tambah Transaksi Gaji</div>
            </div>
        </div>

        <section class="section-body">
            <h2 class="section-title">Form Transaksi Gaji</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payrolls.store', Crypt::encrypt($periode->id)) }}" method="POST"
                        onsubmit="showLoading(this)">
                        @csrf
                        <div class="mt-3" id="formTabsContent">
                            {{-- Form Transaksi --}}

                            <div class="row align-items-end g-3 mb-3">
                                <div class="col-auto">
                                    <input type="number" id="rowCount" class="form-control border-success" value="1"
                                        min="1" style="width: 85px;">
                                </div>
                                <div class="col-auto">
                                    <label class="form-label invisible">.</label>
                                    <button type="button" class="btn btn-success btn-sm shadow-sm" id="addRow">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Baris
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle text-center" id="transactionTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Gaji Pokok</th>
                                            <th>Potongan Lain-lain</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="id_employe[]"
                                                    class="employeSearch select2 @error('id_employe.*') is-invalid @enderror form-control"
                                                    style="width: 100%">
                                                    <option value="">Pilih karyawan</option>
                                                    @foreach ($employees as $item)
                                                        <option value="{{ $item->id_employe_pay }}">
                                                            {{ $item->name_employe }} - ({{ $item->name_group }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('id_employe.*'))
                                                    <span
                                                        class="text-danger text-sm">{{ $errors->first('id_employe.*') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number" name="payroll[]"
                                                    class="form-control @error('payroll.*') is-invalid @enderror"
                                                    placeholder="Nominal Gaji">
                                                @if ($errors->has('payroll.*'))
                                                    <span
                                                        class="text-danger text-sm">{{ $errors->first('payroll.*') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number" name="another_piece[]"
                                                    class="form-control  @error('another_piece.*') is-invalid @enderror"
                                                    placeholder="Potongan">
                                                @if ($errors->has('another_piece.*'))
                                                    <span
                                                        class="text-danger text-sm">{{ $errors->first('another_piece.*') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="list_payroll[]"
                                                    class="form-control @error('list_payroll.*') is-invalid @enderror">
                                                    <option value="">-- Pilih Jenis Gaji --</option>
                                                    <option value="Harian"
                                                        {{ old('list_payroll') == 'Harian' ? 'selected' : '' }}>Harian
                                                    </option>
                                                    <option value="Bulanan"
                                                        {{ old('list_payroll') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                                                    </option>
                                                </select>

                                                @if ($errors->has('list_payroll.*'))
                                                    <span class="text-danger text-sm">
                                                        {{ $errors->first('list_payroll.*') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" name="desc_payroll[]"
                                                    class="form-control @error('desc_payroll.*') is-invalid @enderror"
                                                    placeholder="Deskripsi">
                                                @if ($errors->has('desc_payroll.*'))
                                                    <span
                                                        class="text-danger text-sm">{{ $errors->first('desc_payroll.*') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm removeRow">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg save-btn">
                                <i class="fas fa-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('script')
    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            const tableBody = document.querySelector('#transactionTable tbody');
            const count = parseInt(document.getElementById('rowCount').value) || 1;
            const currentRows = tableBody.querySelectorAll('tr').length;

            for (let i = 0; i < count; i++) {
                // const index = currentRows + i;
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td>
                    <select name="id_employe[]"
                        class="employeSearch select2 @error('id_employe.*') is-invalid @enderror form-control"
                        style="width: 100%">
                        <option value="">Pilih karyawan</option>
                        @foreach ($employees as $item)
                            <option value="{{ $item->id_employe_pay }}">
                                {{ $item->name_employe }} - ({{ $item->name_group }})
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_employe.*'))
                        <span
                            class="text-danger text-sm">{{ $errors->first('id_employe.*') }}</span>
                    @endif
                </td>
                <td>
                    <input type="number" name="payroll[]"
                        class="form-control @error('payroll.*') is-invalid @enderror"
                        placeholder="Nominal Gaji">
                    @if ($errors->has('payroll.*'))
                        <span
                            class="text-danger text-sm">{{ $errors->first('payroll.*') }}</span>
                    @endif
                </td>
                <td>
                    <input type="number" name="another_piece[]"
                        class="form-control  @error('another_piece.*') is-invalid @enderror"
                        placeholder="Potongan">
                    @if ($errors->has('another_piece.*'))
                        <span
                            class="text-danger text-sm">{{ $errors->first('another_piece.*') }}</span>
                    @endif
                </td>
                <td>
                    <select name="list_payroll[]"
                        class="form-control @error('list_payroll.*') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Gaji --</option>
                        <option value="Harian"
                            {{ old('list_payroll') == 'Harian' ? 'selected' : '' }}>Harian
                        </option>
                        <option value="Bulanan"
                            {{ old('list_payroll') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                        </option>
                    </select>

                    @if ($errors->has('list_payroll.*'))
                        <span class="text-danger text-sm">
                            {{ $errors->first('list_payroll.*') }}
                        </span>
                    @endif
                </td>
                <td>
                    <input type="text" name="desc_payroll[]"
                        class="form-control @error('desc_payroll.*') is-invalid @enderror"
                        placeholder="Deskripsi">
                    @if ($errors->has('desc_payroll.*'))
                        <span
                            class="text-danger text-sm">{{ $errors->first('desc_payroll.*') }}</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm removeRow">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            `;
                tableBody.appendChild(newRow);
            }

            $('.select2').select2();
        });

        document.getElementById('transactionTable').addEventListener('click', function(e) {
            if (e.target.closest('.removeRow')) {
                e.target.closest('tr').remove();
            }
        });

        function showLoading(form) {
            let button = form.querySelector(".save-btn");
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Process Save...';
            button.disabled = true;
        }
    </script>
@endsection
