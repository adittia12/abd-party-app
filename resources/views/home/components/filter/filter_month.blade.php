<form action="{{ route('home') }}" method="GET">
    <div class="d-flex flex-row">
        <div class="p-2">
            <input type="month" class="form-control" id="filteringMonth" name="filteringMonth"
                aria-describedby="filteringMonth">
        </div>
        <div class="p-2">
            <button class="btn btn-outline-success btn-sm"><i class="fa-regular fa-circle-dot"></i> Filter</button>
        </div>
    </div>
</form>
