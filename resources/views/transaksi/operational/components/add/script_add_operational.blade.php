<script>
    document.getElementById('addRow').addEventListener('click', function() {
        const tableBody = document.querySelector('#transactionTable tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td>
            <select name="id_employe[]"
                    class="employeSearch select2 @error('id_employe.*') is-invalid @enderror"
                    style="width: 100%">
                <option value="">Pilih karyawan</option>
                @foreach ($listEmploye as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }} - ({{ $item->name_group }})
                    </option>
                @endforeach
            </select>
            @if ($errors->has('id_employe.*'))
                <span class="text-danger text-sm">{{ $errors->first('id_employe.*') }}</span>
            @endif
        </td>
        <td style="position: relative;">
                <!-- Input untuk angka mentah -->
                <input type="number" name="expend[]" id="expend"
                    value="{{ old('expend[]') }}"
                    class="form-control expend-input @error('expend.*') is-invalid @enderror number-input"
                    placeholder="Nominal"
                    style="width: 70%; padding-right: 30px;">

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
                    <span
                        class="text-danger text-sm">{{ $errors->first('expend.*') }}</span>
                @endif
            </td>
            <td>
                <select name="jenis_pemasukan[]" id="jenis_pemasukan"
                    class="select2 @error('jenis_pemasukan.*') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih Pemasukkan</option>
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
        <td>
            <button type="button" class="btn btn-danger removeRow">Hapus</button>
        </td>
    `;
        tableBody.appendChild(newRow);

        // Inisialisasi ulang Select2 untuk elemen baru
        $('.select2').select2();
    });

    document.getElementById('transactionTable').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });
</script>

<script>
    // Fungsi untuk memformat angka menjadi Rupiah
    function formatRupiah(angka) {
        const numberString = angka.replace(/[^,\d]/g, '').toString();
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    // Event listener untuk input angka mentah
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('number-input')) {
            const rawValue = e.target.value || '0';
            const formattedValue = formatRupiah(rawValue);

            // Update elemen overlay
            const formattedText = e.target.closest('td').querySelector('.formatted-text');
            formattedText.textContent = formattedValue;
        }
    });
</script>

<script>
    // Fungsi untuk memformat angka menjadi format Rupiah
    function formatRupiah(angka) {
        const numberString = angka.toString().replace(/[^,\d]/g, '');
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return `Rp ${rupiah}`;
    }

    // Fungsi untuk menghitung total pengeluaran dan sisa pemasukkan
    function calculateTotals() {
        const expendInputs = document.querySelectorAll('.expend-input');
        let totalExpend = 0;

        // Hitung total pengeluaran
        expendInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            totalExpend += value;
        });

        // Update total pengeluaran
        document.getElementById('totalExpend').textContent = formatRupiah(totalExpend);

        // Ambil nilai budget dari input data operasional
        const budget = parseFloat(document.getElementById('budgetInput').value) || 0;

        // Update tampilan budget di tabel
        document.getElementById('displayBudget').textContent = formatRupiah(budget);

        // Hitung sisa pemasukkan
        const remainingIncome = budget - totalExpend;

        // Update sisa pemasukkan
        document.getElementById('remainingIncome').textContent = formatRupiah(remainingIncome > 0 ? remainingIncome :
            0);
    }

    // Event listener untuk input pengeluaran atau budget
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('expend-input') || e.target.id === 'budgetInput') {
            calculateTotals();
        }
    });

    // Event listener untuk tombol "Hapus"
    document.getElementById('transactionTable').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });
</script>
