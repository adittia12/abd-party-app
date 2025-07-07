<script>
    document.getElementById('addRow').addEventListener('click', function() {
        const tableBody = document.querySelector('#transactionTable tbody');
        const count = parseInt(document.getElementById('rowCount').value) || 1;
        for (let i = 0; i < count; i++) {
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

            <td>
                    <select name="jenis_pemasukan[]" class="select2 select-jenis @error('jenis_pemasukan.*') is-invalid @enderror" style="width: 100%">
                        <option value="">Pilih Jenis</option>
                        @foreach ($listBudget as $item)
                            <option value="{{ $item->id }}">{{ $item->list_budget }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('jenis_pemasukan.*'))
                        <span class="text-danger text-sm">{{ $errors->first('jenis_pemasukan.*') }}</span>
                    @endif
                </td>

                <td style="position: relative;">
                    <input type="number" name="expend[]" class="form-control nominal-expend expend-input @error('expend.*') is-invalid @enderror number-input" placeholder="Nominal" style="width: 70%; padding-right: 30px;" disabled>
                    <div class="formatted-text" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none; color: gray; font-size: 0.9em;"><b>Rp 0</b></div>
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
    `;
            tableBody.appendChild(newRow);
        }
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
    function updateNominalState(row) {
        const select = row.querySelector('.select-jenis');
        const input = row.querySelector('.expend-input');

        if (select && input) {
            input.disabled = (select.value === '');
        }
    }

    function initRowListeners(row) {
        const select = row.querySelector('.select-jenis');

        if (select) {
            $(select).on('change', function() {
                updateNominalState(row);
            });
        }

        updateNominalState(row); // inisialisasi awal
    }

    // Untuk baris yang sudah ada saat page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#transactionTable tbody tr').forEach(function(row) {
            initRowListeners(row);
        });
    });

    // Perbarui agar bisa menangani banyak baris yang baru ditambahkan
    document.getElementById('addRow').addEventListener('click', function() {
        setTimeout(function() {
            // Ambil semua baris (tr) yang belum diinisialisasi
            document.querySelectorAll('#transactionTable tbody tr').forEach(function(row) {
                if (!row.classList.contains('initialized')) {
                    $(row).find('.select2').select2(); // Inisialisasi select2
                    initRowListeners(row); // Inisialisasi listener change
                    row.classList.add('initialized'); // Tandai sudah diproses
                }
            });
        }, 100); // Tunggu DOM update
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

    // Simpan nilai awal budget (dari input manual terakhir)
    let manualBudget = parseFloat(document.getElementById('budgetInput').value) || 0;

    // Saat user input manual di budgetInput, update manualBudget
    document.getElementById('budgetInput').addEventListener('input', function() {
        manualBudget = parseFloat(this.value) || 0;
        calculateTotals();
    });

    function calculateTotals() {
        const rows = document.querySelectorAll('#transactionTable tbody tr');
        let totalAdditions = 0;
        let totalExpend = 0;

        rows.forEach(row => {
            const expendInput = row.querySelector('.expend-input');
            const jenisSelect = row.querySelector('select[name="jenis_pemasukan[]"]');

            const value = parseFloat(expendInput.value) || 0;
            const jenisText = jenisSelect.options[jenisSelect.selectedIndex]?.text.trim() || "";

            if (jenisText === "Budget Baru" || jenisText === "Bayar Hutang") {
                totalAdditions += value;
            } else {
                totalExpend += value;
            }
        });

        // Total budget = manualBudget + totalAdditions
        const totalBudget = manualBudget + totalAdditions;

        // Update budgetInput hanya jika nilainya berbeda (untuk menghindari infinite loop)
        const budgetInput = document.getElementById('budgetInput');
        if (parseFloat(budgetInput.value) !== totalBudget) {
            budgetInput.value = totalBudget.toFixed(2);
        }

        // Update tampilan budget dan pengeluaran
        document.getElementById('displayBudget').textContent = formatRupiah(totalBudget);
        document.getElementById('totalExpend').textContent = formatRupiah(totalExpend);

        let remainingIncome = totalBudget - totalExpend;
        if (remainingIncome < 0) remainingIncome = 0;

        document.getElementById('remainingIncome').textContent = formatRupiah(remainingIncome);
    }



    // Event listener untuk input pengeluaran, jenis pemasukan, atau budget awal
    document.addEventListener('input', function(e) {
        if (
            e.target.classList.contains('expend-input') ||
            e.target.id === 'budgetInput' ||
            e.target.name === 'jenis_pemasukan[]'
        ) {
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

    // Jalankan sekali saat halaman load supaya nilai muncul
    window.addEventListener('DOMContentLoaded', calculateTotals);
</script>
