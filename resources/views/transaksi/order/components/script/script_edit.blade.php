<script>
    $(document).ready(function() {
        // Autofill product details when product is selected
        $(document).on('change', '.productSearch', function() {
            var productId = $(this).val();
            var $row = $(this).closest('tr');

            if (productId) {
                $.ajax({
                    url: '{{ route('order.autofill_product') }}',
                    type: 'POST',
                    data: {
                        id_product: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $row.find('input[name="days[]"]').val(data.sales_price);
                        $row.find('input[name="measure_list[]"]').val(data.unit_measure);
                        updateTotalHarga($row);
                    },
                    error: function() {
                        alert('Data not found');
                    }
                });
            }
        });

        $(document).on('change', '.product_search', function() {
            var productIdOrder = $(this).val();
            var $row = $(this).closest('tr');

            if (productIdOrder) {
                $.ajax({
                    url: '{{ route('order.autofill_product_order') }}',
                    type: 'POST',
                    data: {
                        new_id_product: productIdOrder,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        $row.find('input[name="new_days[]"]').val(data.sales_price);
                        $row.find('input[name="new_measure_list[]"]').val(data
                            .unit_measure);
                        updateTotalHargaOrder($row);
                    },
                    error: function() {
                        alert('Data not found');
                    }
                });
            }
        });

        // Calculate total price based on quantity and unit price
        $(document).on('input', 'input[name="qty[]"], input[name="price[]"]', function() {
            var $row = $(this).closest('tr');
            updateTotalHarga($row);
        });

        $(document).on('input', 'input[name="new_qty[]"], input[name="new_price[]"]', function() {
            var $row = $(this).closest('tr');
            updateTotalHargaOrder($row);
        });

        function updateTotalHarga($row) {
            var qty = parseFloat($row.find('input[name="qty[]"]').val()) || 0;
            var price = parseFloat($row.find('input[name="price[]"]').val()) || 0;
            var totalHarga = qty * price;
            $row.find('input[name="total_harga[]"]').val(formatRupiah(totalHarga));
        }

        function updateTotalHargaOrder($row) {
            var qty = parseFloat($row.find('input[name="new_qty[]"]').val()) || 0;
            var price = parseFloat($row.find('input[name="new_price[]"]').val()) || 0;
            var totalHarga = qty * price;
            $row.find('input[name="new_total_harga[]"]').val(formatRupiah(totalHarga));
        }

        // Add new row for transaction
        $("#addBtn").on("click", function() {
            var newRow = `
                <tr>
                    <td class="row-index">${$('#transaksiOrder tbody tr').length + 1}</td>
                    <td>
                        <select name="new_id_product[]" class="product_search select2">
                            <option value="">Select Product (Barang)</option>
                            @foreach ($dataProduct as $item)
                                <option value="{{ $item->id }}">
                                    ({{ $item->inter_ref }}) - {{ $item->name_product }}
                                </option>
                            @endforeach
                        </select>
                        @error('new_id_product.*')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </td>
                    <td>
                        <input type="text" name="new_description[]" value="{{ old('new_description[]') }}" placeholder="Ketik Deskripsi" class="@error('new_description.*') is-invalid @enderror">
                        @error('new_description.*')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </td>
                    <td hidden>
                        <input type="number" name="new_days[]" placeholder="Hari">
                    </td>
                    <td>
                        <input type="number" name="new_qty[]" value="{{ old('new_qty[]') }}" class="@error('new_qty.*') is-invalid @enderror" style="width: 50px" placeholder="Quantity">
                        @error('new_qty.*')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </td>
                    <td hidden>
                        <input type="text" name="new_measure_list[]" placeholder="Jenis Satuan">
                    </td>
                    <td>
                        <input type="number" name="new_price[]" class="@error('new_price.*') is-invalid @enderror" style="width: 120px" placeholder="Ketik harga">
                        @error('new_price.*')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </td>
                    <td>
                        <input type="text" name="new_total_harga[]" placeholder="Jumlah Harga" style="width: 150px" readonly>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-danger remove btn-sm" title="Remove">Delete</a>
                    </td>
                </tr>`;
            $("#transaksiOrder tbody").append(newRow);
            $(".product_search").select2({
                allowClear: true
            });
        });

        // Delete new row
        $("#transaksiOrder tbody").on("click", ".remove", function() {
            var child = $(this).closest("tr").nextAll();
            child.each(function() {
                var idx = $(this).children(".row-index");
                var currentIndex = parseInt(idx.text());
                idx.text(currentIndex - 1);
            });
            $(this).closest("tr").remove();
            updateRowNumbers();
        });

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
                        url: '/order/delete-transaction/' + transactionId,
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

        // Function to update row numbers
        function updateRowNumbers() {
            $("#transaksiOrder tbody tr").each(function(index) {
                $(this).find(".row-index").text(index + 1);
            });
        }
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
</script>

<script>
    document.getElementById('start_event').addEventListener('change', function() {
        var startDate = new Date(this.value);
        if (!isNaN(startDate.getTime())) {
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 1);
            var year = endDate.getFullYear();
            var month = (endDate.getMonth() + 1).toString().padStart(2, '0');
            var day = endDate.getDate().toString().padStart(2, '0');
            var formattedEndDate = year + '-' + month + '-' + day;
            document.getElementById('end_event').value = formattedEndDate;
        }
    });
</script>
