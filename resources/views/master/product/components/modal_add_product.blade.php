<!-- Modal -->
<div class="modal fade" id="add_product" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name_product">Nama Produk</label>
                        <input type="text" class="form-control @error('name_product') is-invalid @enderror"
                            id="name_product" name="name_product" value="{{ old('name_product') }}"
                            placeholder="Nama Produk">
                        @if ($errors->has('name_product'))
                            <span class="text-danger text-sm">{{ $errors->first('name_product') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sales_price">Sales Price</label>
                        <input type="number" class="form-control @error('sales_price') is-invalid @enderror"
                            id="sales_price" name="sales_price" value="{{ old('sales_price') }}"
                            placeholder="Sales Price">
                        @if ($errors->has('sales_price'))
                            <span class="text-danger text-sm">{{ $errors->first('sales_price') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="unit_measure">Unit Measure</label>
                        <input type="text" class="form-control @error('unit_measure') is-invalid @enderror"
                            id="unit_measure" name="unit_measure" value="{{ old('unit_measure') }}"
                            placeholder="Unit Measure">
                        @if ($errors->has('unit_measure'))
                            <span class="text-danger text-sm">{{ $errors->first('unit_measure') }}</span>
                        @endif
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
