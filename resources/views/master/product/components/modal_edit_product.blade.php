<!-- Modal -->
<div class="modal fade" id="edit_product" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="inter_ref">Kode Produk</label>
                            <input type="text" class="form-control" id="e_inter_ref" name="inter_ref" value=""
                                placeholder="Kode produk">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="name_product">Nama Produk</label>
                            <input type="text" class="form-control" id="e_name_product" name="name_product"
                                value="" placeholder="Nama Produk">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="sales_price">Sales Price</label>
                        <input type="number" class="form-control" id="e_sales_price" name="sales_price" value=""
                            placeholder="Sales Price">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="unit_measure">Unit Measure</label>
                        <input type="text" class="form-control" id="e_unit_measure" name="unit_measure"
                            value="" placeholder="Unit Measure">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
