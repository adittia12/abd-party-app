<div class="col">
    @if ($filterMonth)
        <div class="alert alert-success alert-dismissible show fade" role="alert" x-data="{ show: true }" x-show="show"
            x-init="setTimeout(() => show = false, 5000)">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <strong>Filter : </strong>
                {{ \Carbon\Carbon::parse($filterMonth)->format('F Y') }}
            </div>
        </div>
    @endif
    @if ($filterYear)
        <div class="alert alert-success alert-dismissible show fade" role="alert" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <strong>Filter : </strong> {{ $filterYear }}
            </div>
        </div>
    @endif
</div>
