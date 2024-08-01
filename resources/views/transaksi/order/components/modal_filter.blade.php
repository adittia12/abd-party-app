<!-- Modal -->
<div class="modal fade" id="filterData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('order.index') }}" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Filter Bulan</label>
                        <input type="month" class="form-control" id="filteringMonth" name="filteringMonth"
                            aria-describedby="filteringMonth">
                    </div>
                    <div class="form-group">
                        <label for="">Filter Tanggal</label>
                        <input type="date" class="form-control" id="filterDate" name="filterDate"
                            aria-describedby="filterDate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
