<script>
    $(document).ready(function() {
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

        $(document).on('input', 'input[name="qty[]"], input[name="price[]"]', function() {
            var $row = $(this).closest('tr');
            updateTotalHarga($row);
        });

        function updateTotalHarga($row) {
            var qty = parseFloat($row.find('input[name="qty[]"]').val()) || 0;
            var price = parseFloat($row.find('input[name="price[]"]').val()) || 0;
            var totalHarga = qty * price;
            $row.find('input[name="total_harga"]').val(formatRupiah(totalHarga));
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
    let rowIdx = 1;
    $("#addBtn").on("click", function() {
        $("#transaksiOrder tbody").append(`
        <tr id="R${++rowIdx}">
            <td class="row-index text-center"><p>${rowIdx}</p></td>
            <td>
                <select name="id_product[]" id="id_product" class="productSearch select2 @error('id_product.*') is-invalid @enderror">
                    <option value="">Select Product (Barang)</option>
                    @foreach ($dataProduct as $item)
                        <option value="{{ $item->id }}">
                            ({{ $item->inter_ref }}) - {{ $item->name_product }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('id_product.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('id_product.*') }}</span>
                @endif
            </td>
            <td>
                <input type="text" name="description[]" id="description"
                    value="{{ old('description[]') }}" placeholder="Ketik Deskripsi"
                    class="@error('description.*') is-invalid @enderror">
                @if ($errors->has('description.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('description.*') }}</span>
                @endif
            </td>
            <td hidden>
                <input type="number" name="days[]" id="days" placeholder="Hari">
            </td>
            <td>
                <input type="number" name="qty[]" id="qty"
                    value="{{ old('qty[]') }}"
                    class="@error('qty.*') is-invalid @enderror"
                    placeholder="Quantity" style="width: 100px;">
                @if ($errors->has('qty.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('qty.*') }}</span>
                @endif
            </td>
            <td hidden>
                <input type="text" name="measure_list[]" id="measure_list" placeholder="Jenis Satuan">
            </td>
            <td>
                <input type="number" name="price[]" id="price"
                    class="@error('price.*') is-invalid @enderror"
                    placeholder="Ketik harga" style="width: 150px;">
                @if ($errors->has('price.*'))
                    <span
                        class="text-danger text-sm">{{ $errors->first('price.*') }}</span>
                @endif
            </td>
            <td>
                <input type="text" name="total_harga" placeholder="Jumlah Harga" style="width: 150px;" readonly>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn btn-danger remove btn-sm" title="Remove">Delete</a>
            </td>
        </tr>`);
        $(".productSearch").select2({
            allowClear: true
        });
    });

    $("#transaksiOrder tbody").on("click", ".remove", function() {
        var child = $(this).closest("tr").nextAll();
        child.each(function() {
            var id = $(this).attr("id");
            var idx = $(this).children(".row-index").children("p");
            var dig = parseInt(id.substring(1));
            idx.html(`${dig - 1}`);
            $(this).attr("id", `R${dig - 1}`);
        });
        $(this).closest("tr").remove();
        rowIdx--;
    });
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
