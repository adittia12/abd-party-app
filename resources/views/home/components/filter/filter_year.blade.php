<form action="{{ route('home') }}" method="GET">
    <div class="d-flex justify-content-center">
        <div class="p-2">
            <input type="text" class="form-control" id="filterYearCuti" name="filterYear" aria-describedby="filterYear"
                placeholder="Filter Year" value="{{ old('filterYear') }}" autocomplete="off">
        </div>
        <div class="p-2">
            <button class="btn btn-outline-primary btn-sm"><i class="fa-regular fa-circle-dot"></i> Filter</button>
        </div>
    </div>
</form>
