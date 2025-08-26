@extends('frontend.layout.master')
@section('title', 'Edit | Gaji')

@section('content')
    <section class="section">
        @include('sweetalert::alert')

        <div class="section-header">
            <h1>Edit Gaji</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('payrolls.show', Crypt::encrypt($periodeFind->id)) }}">Data Gaji</a>
                </div>
                <div class="breadcrumb-item">Edit Transaksi Gaji</div>
            </div>
        </div>
        @include('sweetalert::alert')
        <section class="section-body">
            <h2 class="section-title">Form Edit Transaksi Gaji</h2>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form
                        action="{{ route('payrolls.update_transpay', [Crypt::encrypt($periodeFind->id), Crypt::encrypt($dataTransPayrolls->id_trans_pay)]) }}"
                        method="POST" onsubmit="showLoading(this)">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="periode">Periode Gaji</label>
                            <span class="form-control">
                                {{ \Carbon\Carbon::parse($dataTransPayrolls->month_period)->translatedFormat('F Y') }}
                            </span>
                        </div>

                        {{-- Pilih Karyawan --}}
                        <div class="form-group">
                            <label for="id_employe">Nama Karyawan <span class="text-danger">* Boleh Edit</span></label>
                            <select class="form-control select2 @error('id_employe') is-invalid @enderror" name="id_employe"
                                id="id_employe" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($dataEmployes as $emp)
                                    <option value="{{ $emp->id_employe_pay }}"
                                        {{ $emp->id_employe_pay == old('id_employe', $dataTransPayrolls->id_employe) ? 'selected' : '' }}>
                                        {{ $emp->name_employe }} - {{ $emp->name_group }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_employe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nominal Gaji --}}
                        <div class="form-group">
                            <label for="payroll">Nominal Gaji <span class="text-danger">* Boleh Edit</span></label>
                            <input type="number" name="payroll" id="payroll"
                                class="form-control @error('payroll') is-invalid @enderror"
                                value="{{ old('payroll', $dataTransPayrolls->payroll) }}" required>
                            @error('payroll')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Potongan Lain --}}
                        <div class="form-group">
                            <label for="another_piece">Potongan Lain <span class="text-danger">* Boleh Edit</span></label>
                            <input type="number" name="another_piece" id="another_piece"
                                class="form-control @error('another_piece') is-invalid @enderror"
                                value="{{ old('another_piece', $dataTransPayrolls->another_piece) }}">
                            @error('another_piece')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="desc_payroll">Keterangan <span class="text-danger">* Boleh Edit</span></label>
                            <textarea name="desc_payroll" id="desc_payroll" rows="3"
                                class="form-control @error('desc_payroll') is-invalid @enderror">{{ old('desc_payroll', $dataTransPayrolls->desc_payroll) }}</textarea>
                            @error('desc_payroll')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis List Payroll --}}
                        <div class="form-group">
                            <label for="list_payroll">Jenis Payroll <span class="text-danger">* Boleh Edit</span></label>
                            <select name="list_payroll" id="list_payroll"
                                class="form-control @error('list_payroll') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Payroll --</option>
                                <option value="Harian"
                                    {{ old('list_payroll', $dataTransPayrolls->list_payroll) == 'Harian' ? 'selected' : '' }}>
                                    Harian
                                </option>
                                <option value="Bulanan"
                                    {{ old('list_payroll', $dataTransPayrolls->list_payroll) == 'Bulanan' ? 'selected' : '' }}>
                                    Bulanan
                                </option>
                            </select>
                            @error('list_payroll')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <fieldset disabled>
                            {{-- Expend Kasbon (read only) --}}
                            <div class="form-group">
                                <label for="expend_kasbon">Kasbon (jika ada)</label>
                                <input type="text" id="expend_kasbon" class="form-control"
                                    value="{{ $dataTransPayrolls->expend_kasbon ? 'Rp ' . number_format($dataTransPayrolls->expend_kasbon, 0, ',', '.') : '-' }}"
                                    readonly>
                            </div>

                            {{-- Hasil Akhir Gaji Diterima --}}
                            @php
                                $kasbon = $dataTransPayrolls->expend_kasbon ?? 0;
                                $potongan = $dataTransPayrolls->another_piece ?? 0;
                                $gajiBersih = $dataTransPayrolls->payroll - ($kasbon + $potongan);
                            @endphp
                            <div class="form-group">
                                <label for="gaji_bersih">Gaji Diterima</label>
                                <input type="text" id="gaji_bersih" class="form-control font-weight-bold"
                                    value="{{ 'Rp ' . number_format($gajiBersih, 0, ',', '.') }}" readonly>
                            </div>
                        </fieldset>

                        <div class="form-group text-right">
                            <a href="{{ route('payrolls.show', Crypt::encrypt($periodeFind->id)) }}"
                                class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
@endsection
