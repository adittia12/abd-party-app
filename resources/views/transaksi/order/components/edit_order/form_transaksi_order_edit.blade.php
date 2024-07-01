<table class="table table-hover table-striped" id="transaksiOrder">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Descriptions</th>
            <th>Quantity</th>
            <th>Harga Satuan</th>
            <th>Jumlah Harga</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTransaksi as $key => $transaksi)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    <input type="hidden" name="id_transaksi[]" value="{{ $transaksi->id }}">
                    <select name="id_product[]" id="id_product"
                        class="productSearch select2 @error('id_product.*') is-invalid @enderror">
                        <option value="{{ $transaksi->id_product }}">
                            ({{ $transaksi->inter_ref }})
                            -
                            {{ $transaksi->name_product }}</option>
                        @foreach ($dataProduct as $product)
                            <option value="{{ $product->id }}">
                                ({{ $product->inter_ref }})
                                - {{ $product->name_product }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_product.*'))
                        <span class="text-danger text-sm">{{ $errors->first('id_product.*') }}</span>
                    @endif
                </td>
                <td>
                    <input type="text" name="description[]" id="description" value="{{ $transaksi->description }}"
                        placeholder="Ketik Deskripsi" class="@error('description.*') is-invalid @enderror">
                    @if ($errors->has('description.*'))
                        <span class="text-danger text-sm">{{ $errors->first('description.*') }}</span>
                    @endif
                </td>
                <td hidden>
                    <input type="number" name="days[]" value="{{ $transaksi->days }}" placeholder="Hari">
                </td>
                <td>
                    <input type="number" name="qty[]" id="qty" value="{{ $transaksi->qty }}"
                        class="@error('qty.*') is-invalid @enderror" placeholder="Quantity" style="width: 50px">
                    @if ($errors->has('qty.*'))
                        <span class="text-danger text-sm">{{ $errors->first('qty.*') }}</span>
                    @endif
                </td>
                <td hidden>
                    <input type="text" name="measure_list[]" value="{{ $transaksi->measure_list }}"
                        id="measure_list" placeholder="Jenis Satuan">
                </td>
                <td>
                    <input type="number" name="price[]" value="{{ $transaksi->price }}" id="price"
                        class="@error('price.*') is-invalid @enderror" placeholder="Ketik harga" style="width: 120px">
                    @if ($errors->has('price.*'))
                        <span class="text-danger text-sm">{{ $errors->first('price.*') }}</span>
                    @endif
                </td>
                <td>
                    <input type="text" name="total_harga[]"
                        value="{{ $transaksi->price * $transaksi->qty == 0 ? '0' : number_format($transaksi->price * $transaksi->qty, 0, ',', '.') }}"
                        placeholder="Jumlah Harga" style="width: 150px" readonly>
                </td>

                <td>
                    <a href="javascript:void(0)" class="btn btn-danger remove-trans btn-sm"
                        data-id="{{ $transaksi->id }}">Delete</a>
                </td>


            </tr>
        @endforeach

    </tbody>
</table>
