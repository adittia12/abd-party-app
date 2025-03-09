<script>
    document.getElementById('addRow').addEventListener('click', function() {
        const tableBody = document.querySelector('#transactionTable tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td class="row-index">${$('#transactionTable tbody tr').length + 1}</td>
        <td>
            <select name="new_id_employe[]"
                    class="employeSearch select2 @error('new_id_employe.*') is-invalid @enderror"
                    style="width: 100%">
                <option value="">Pilih karyawan</option>
                @foreach ($listEmploye as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }} - ({{ $item->name_group }})
                    </option>
                @endforeach
            </select>
            @if ($errors->has('new_id_employe.*'))
                <span class="text-danger text-sm">{{ $errors->first('new_id_employe.*') }}</span>
            @endif
        </td>
        <td style="position: relative;">
                <!-- Input untuk angka mentah -->
                <input type="number" name="new_expend[]" id="expend"
                    value="{{ old('new_expend[]') }}"
                    class="form-control expend-input @error('new_expend.*') is-invalid @enderror number-input"
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

                @if ($errors->has('new_expend.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('new_expend.*') }}</span>
                @endif
            </td>
            <td>
                <select name="new_id_list_budget[]" id="new_id_list_budget"
                    class="select2 @error('new_id_list_budget.*') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih Pemasukkan</option>
                    @foreach ($listBudget as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->list_budget }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('new_id_list_budget.*'))
                    <span class="text-danger text-sm">{{ $errors->first('new_id_list_budget.*') }}</span>
                @endif
            </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
        </td>
    `;
        tableBody.appendChild(newRow);

        // Inisialisasi ulang Select2 untuk elemen baru
        $('.select2').select2();

        // Delete new row
        $("#transactionTable tbody").on("click", ".removeRow", function() {
            var child = $(this).closest("tr").nextAll();
            child.each(function() {
                var idx = $(this).children(".row-index");
                var currentIndex = parseInt(idx.text());
                idx.text(currentIndex - 1);
            });
            $(this).closest("tr").remove();
            updateRowNumbers();
        });
        // Function to update row numbers
        function updateRowNumbers() {
            $("#transactionTable tbody tr").each(function(index) {
                $(this).find(".row-index").text(index + 1);
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Delete transaction row
        $('.remove-trans').click(function() {
            var transactionId = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/operational/detele-operational-trans/' + transactionId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                Swal.fire(
                                    'Deleted!',
                                    response.success,
                                    'success'
                                );
                                updateRowNumbers();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Error deleting transaction.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Error deleting transaction.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    })
</script>

<script>
    // Fungsi untuk memformat angka menjadi Rupiah
    function formatRupiah(angka) {
        let numberString = angka.replace(/[^,\d]/g, '').toString();
        let split = numberString.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah;
    }

    // Event listener untuk input angka mentah
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('number-input')) {
            let rawValue = e.target.value.trim();

            // Jika input kosong, tampilkan Rp 0
            let formattedValue = rawValue ? formatRupiah(rawValue) : 'Rp 0';

            // Update elemen overlay
            let formattedText = e.target.closest('td').querySelector('.formatted-text');
            formattedText.innerHTML = `<b>${formattedValue}</b>`;
        }
    });

    // Menampilkan format rupiah pada form edit saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.number-input').forEach(function(input) {
            let rawValue = input.value.trim();
            if (rawValue) {
                let formattedText = input.closest('td').querySelector('.formatted-text');
                formattedText.innerHTML = `<b>${formatRupiah(rawValue)}</b>`;
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatRupiah(angka) {
            let isNegative = angka < 0;
            let absAngka = Math.abs(angka); // Ambil nilai absolut agar format angka tetap benar
            let numberString = absAngka.toString().replace(/[^,\d]/g, '');
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return isNegative ? `-Rp ${rupiah}` : `Rp ${rupiah}`;
        }

        function calculateTotals() {
            let totalExpend = 0;

            // Mengambil semua input pengeluaran
            document.querySelectorAll('.expend-input').forEach(input => {
                let value = parseFloat(input.value) || 0;
                totalExpend += value;

                // Update tampilan format Rupiah pada elemen overlay
                let formattedText = input.closest('td').querySelector('.formatted-text b');
                if (formattedText) {
                    formattedText.textContent = formatRupiah(value);
                }
            });

            // Update total pengeluaran
            document.getElementById('totalExpend').textContent = formatRupiah(totalExpend);

            // Mengambil nilai budget dari input
            let budget = parseFloat(document.getElementById('budgetInput').value) || 0;
            document.getElementById('displayBudget').textContent = formatRupiah(budget);

            // Hitung sisa budget
            let remainingIncome = budget - totalExpend;
            let remainingElement = document.getElementById('remainingIncome');

            remainingElement.textContent = formatRupiah(remainingIncome);

            // Jika sisa budget negatif, tampilkan dalam warna merah
            if (remainingIncome < 0) {
                remainingElement.style.color = 'red';
            } else {
                remainingElement.style.color = 'black';
            }
        }

        // Event listener untuk input pengeluaran dan budget
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('expend-input') || e.target.id === 'budgetInput') {
                calculateTotals();
            }
        });

        // Event listener untuk tombol hapus transaksi
        document.getElementById('transactionTable').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                let row = e.target.closest('tr');

                // Hapus nilai expend sebelum menghapus baris agar update sisa budget
                let expendInput = row.querySelector('.expend-input');
                if (expendInput) {
                    expendInput.value = 0;
                }

                // Hapus baris dan hitung ulang
                row.remove();
                calculateTotals();
            }
            if (e.target.classList.contains('remove-trans')) {
                let row = e.target.closest('tr');

                // Hapus nilai expend sebelum menghapus baris agar update sisa budget
                let expendInput = row.querySelector('.expend-input');
                if (expendInput) {
                    expendInput.value = 0;
                }

                // Hapus baris dan hitung ulang
                row.remove();
                calculateTotals();
            }
        });

        // Panggil fungsi saat halaman pertama kali dimuat untuk menampilkan data awal
        calculateTotals();
    });
</script>
