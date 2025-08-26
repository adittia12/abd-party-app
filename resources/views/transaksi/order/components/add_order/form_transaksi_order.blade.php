<div class="d-flex align-items-center mb-2">
    <input type="number" id="jumlahBaris" value="1" min="1" style="width: 80px;"
        class="form-control form-control-sm mr-2">
    <button type="button" class="btn btn-success btn-sm" id="addBtn">Add Row</button>
</div>

<table class="table table-hover table-striped" id="transaksiOrder">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Descriptions</th>
            <th>Quantity</th>
            <th>Harga Satuan</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>
                <select name="id_product[]" id="id_product"
                    class="productSearch select2 @error('id_product.*') is-invalid @enderror" style="width: 100%">
                    <option value="">Select Product (Barang)</option>
                    @foreach ($dataProduct as $item)
                        <option value="{{ $item->id }}">
                            ({{ $item->inter_ref }})
                            - {{ $item->name_product }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('id_product.*'))
                    <span class="text-danger text-sm">{{ $errors->first('id_product.*') }}</span>
                @endif
            </td>
            <td>
                <input type="text" name="description[]" id="description" value="{{ old('description[]') }}"
                    placeholder="Ketik Deskripsi" class="@error('description.*') is-invalid @enderror">
                @if ($errors->has('description.*'))
                    <span class="text-danger text-sm">{{ $errors->first('description.*') }}</span>
                @endif
            </td>
            <td hidden>
                <input type="number" name="days[]" id="days" placeholder="Hari">
            </td>
            <td>
                <input type="number" name="qty[]" id="qty" value="{{ old('qty[]') }}"
                    class="@error('qty.*') is-invalid @enderror" placeholder="Quantity" style="width: 100px;">
                @if ($errors->has('qty.*'))
                    <span class="text-danger text-sm">{{ $errors->first('qty.*') }}</span>
                @endif
            </td>
            <td hidden>
                <input type="text" name="measure_list[]" id="measure_list" placeholder="Jenis Satuan">
            </td>
            <td>
                <input type="number" name="price[]" id="price" class="@error('price.*') is-invalid @enderror"
                    placeholder="Ketik harga" style="width: 150px;">
                @if ($errors->has('price.*'))
                    <span class="text-danger text-sm">{{ $errors->first('price.*') }}</span>
                @endif
            </td>
            <td>
                <input type="text" name="total_harga" placeholder="Jumlah Harga" style="width: 150px;" readonly>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Add" id="addBtn">Add Row</a>
            </td>
        </tr>
    </tbody>
</table>
