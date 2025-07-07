<script>
    document.getElementById('addRow').addEventListener('click', function() {
        const tableBody = document.querySelector('#transactionTable tbody');
        const count = parseInt(document.getElementById('rowCount').value) || 1;
        for (let i = 0; i < count; i++) {
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-new', 'true');
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
            <td>
                <select name="new_id_list_budget[]" id="new_id_list_budget"
                    class="select2 select-jenis @error('new_id_list_budget.*') is-invalid @enderror" style="width: 100%">
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
            <td style="position: relative;">
                <!-- Input untuk angka mentah -->
                <input type="number" name="new_expend[]" id="expend"
                    value="{{ old('new_expend[]') }}"
                    class="form-control nominal-expend expend-input @error('new_expend.*') is-invalid @enderror number-input"
                    placeholder="Nominal"
                    style="width: 70%; padding-right: 30px;" disabled>

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
                <input type="text" name="new_description[]" id="new_description"
                    class="form-control @error('new_description.*') is-invalid @enderror"
                    value="{{ old('new_description[]') }}"
                    placeholder="Deskripsi">
                @if ($errors->has('new_description.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('new_description.*') }}</span>
                @endif
            </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
        </td>
    `;
            tableBody.appendChild(newRow);
        }

        // Inisialisasi ulang semua .select2
        $('.select2').select2();

        updateRowNumbers(); // Perbarui nomor urutan
    });

    // Hapus baris
    $("#transactionTable tbody").on("click", ".removeRow", function() {
        $(this).closest("tr").remove();
        updateRowNumbers();
    });

    // Update nomor baris
    function updateRowNumbers() {
        $("#transactionTable tbody tr").each(function(index) {
            $(this).find(".row-index").text(index + 1);
        });
    }
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
    $(document).ready(function() {
        $('.remove-trans').click(function(e) {
            e.preventDefault(); // penting jika tombol di form

            var transactionId = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                allowOutsideClick: false, // ⛔ Tidak bisa klik di luar
                allowEscapeKey: false, // ⛔ Tidak bisa tekan ESC
                allowEnterKey: false // ⛔ Tidak bisa tekan Enter
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
    });
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
            let additionalBudget = 0;

            const budgetInput = document.getElementById('budgetInput');
            const initialBudget = parseFloat(budgetInput.getAttribute('data-initial-budget')) || 0;

            document.querySelectorAll('#transactionTable tbody tr').forEach(row => {
                let expendInput = row.querySelector('.expend-input');
                let expend = parseFloat(expendInput?.value) || 0;

                const isOldRow = row.getAttribute('data-new') !== 'true';

                let jenisSelect = row.querySelector('select[name="jenis_pemasukan[]"]') ||
                    row.querySelector('select[name="new_id_list_budget[]"]');

                let jenisText = jenisSelect && jenisSelect.options[jenisSelect.selectedIndex] ?
                    jenisSelect.options[jenisSelect.selectedIndex].text.toLowerCase().trim() : '';

                // Jika baris dihapus sebelumnya, jangan ikut dihitung
                if (row.classList.contains('deleted-row')) {
                    if ((jenisText.includes('budget baru') || jenisText.includes('bayar hutang')) &&
                        isOldRow) {
                        // Jika baris lama dengan jenis budget baru/bayar hutang dihapus → kurangi dari budget tambahan
                        additionalBudget -= expend;
                    }
                    return; // lewati baris ini
                }

                // Logika normal
                if (jenisText.includes('budget baru') || jenisText.includes('bayar hutang')) {
                    if (!isOldRow) {
                        // Transaksi baru dan jenis budget baru/bayar hutang → tambahkan ke budget
                        additionalBudget += expend;
                    }
                    // Transaksi lama jenis ini → tidak dihitung sebagai pengeluaran
                } else {
                    // Semua jenis lain → pengeluaran
                    totalExpend += expend;
                }

                // Format tampilan rupiah
                let formattedText = row.querySelector('.formatted-text b');
                if (formattedText) {
                    formattedText.textContent = formatRupiah(expend);
                }
            });

            // Hitung budget akhir dan sisa
            const finalBudget = initialBudget + additionalBudget;
            const remainingIncome = finalBudget - totalExpend;

            // Update tampilan
            budgetInput.value = finalBudget.toFixed(2);
            document.getElementById('displayBudget').textContent = formatRupiah(finalBudget);
            document.getElementById('totalExpend').textContent = formatRupiah(totalExpend);

            const remainingElement = document.getElementById('remainingIncome');
            remainingElement.textContent = formatRupiah(remainingIncome);
            remainingElement.style.color = remainingIncome < 0 ? 'red' : 'black';
        }

        // Event listener input
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('expend-input') || e.target.name === 'jenis_pemasukan[]') {
                calculateTotals();
            }
        });

        // Hitung ulang saat halaman siap
        document.addEventListener('DOMContentLoaded', calculateTotals);



        // Event listener untuk input pengeluaran dan budget
        // document.addEventListener('input', function(e) {
        //     if (e.target.classList.contains('expend-input') || e.target.id === 'budgetInput') {
        //         calculateTotals();
        //     }
        // });

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
