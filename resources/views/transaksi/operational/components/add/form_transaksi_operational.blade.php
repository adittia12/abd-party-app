<table class="table table-bordered" id="transactionTable">
    <thead>
        <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Pengeluaran/Pemasukkan</th>
            <th>Nominal</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <select name="id_employe[]" id="id_employe"
                    class="employeSearch select2 @error('id_employe.*') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih karyawan</option>
                    @foreach ($listEmploye as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                            - ({{ $item->name_group }})
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('id_employe.*'))
                    <span class="text-danger text-sm">{{ $errors->first('id_employe.*') }}</span>
                @endif
            </td>
            <td>
                <select name="jenis_pemasukan[]" id="jenis_pemasukan"
                    class="select2 select-jenis @error('jenis_pemasukan.*') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih Jenis</option>
                    @foreach ($listBudget as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->list_budget }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('jenis_pemasukan.*'))
                    <span class="text-danger text-sm">{{ $errors->first('jenis_pemasukan.*') }}</span>
                @endif
            </td>
            <td style="position: relative;">
                <!-- Input untuk angka mentah -->
                <input type="number" name="expend[]" id="expend" value="{{ old('expend[]') }}"
                    class="form-control nominal-expend expend-input @error('expend.*') is-invalid @enderror number-input"
                    placeholder="Nominal" style="width: 70%; padding-right: 30px;" disabled>

                <!-- Elemen overlay untuk menampilkan format Rupiah -->
                <div class="formatted-text"
                    style="
                    position: absolute;
                    top: 50%;
                    right: 10px;
                    transform: translateY(-50%);
                    pointer-events: none;
                    color: gray;
                    font-size: 0.9em;
                ">
                    <b>Rp 0</b>
                </div>

                @if ($errors->has('expend.*'))
                    <span class="text-danger text-sm">{{ $errors->first('expend.*') }}</span>
                @endif
            </td>
            <td>
                <input type="text" name="description[]" id="description" value="{{ old('description[]') }}"
                    class="form-control @error('description.*') is-invalid @enderror" placeholder="Deskripsi">
                @if ($errors->has('description.*'))
                    <span class="text-danger text-sm">{{ $errors->first('description.*') }}</span>
                @endif
            </td>
            <td>
                <button type="button" class="btn btn-danger removeRow">Hapus</button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>Total Pengeluaran</td>
            <td id="totalExpend">Rp 0</td>
        </tr>
        <tr>
            <td>Budget</td>
            <td id="displayBudget">Rp 0</td>
        </tr>
        <tr>
            <td>Sisa Pemasukkan</td>
            <td id="remainingIncome">Rp 0</td>
        </tr>
    </tfoot>
</table>
