@extends('frontend.layout.master')
@section('title')
    Set CP | Pelayanan Stragis
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Pelayanan Strategis</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#add_service_strategy"><i class="fa fa-plus"></i> Tambah Strategis</button>
                            </div>
                        </div>
                    </div>
                    @include('sweetalert::alert')
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <!-- Dropdown di Kiri -->
                            <div class="p-2">
                                <select id="perPageSelect" name="per_page" class="form-control">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <!-- Form Pencarian di Kanan -->
                            <div class="p-2">
                                <form id="searchForm" action="{{ route('service_strategy.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="serviceStrategyTableContainer">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Srategi</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceStrategy as $key => $item)
                                            <tr>
                                                <td>{{ $serviceStrategy->perPage() * ($serviceStrategy->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td hidden class="id_update_serviceStrategy">
                                                    {{ Crypt::encrypt($item->id) }}
                                                </td>
                                                <td class="title">{{ $item->title }}</td>
                                                <td class="description">{{ $item->description }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            More Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item serviceStrategyUpdate"
                                                                    data-toggle="modal" data-id="'.$item->id.'"
                                                                    data-target="#edit_service_strategy"><i
                                                                        class="fas fa-pen-square"></i> Edit</a></li>
                                                            <form
                                                                action="{{ route('service_strategy.destroy', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li><a class="dropdown-item delete-button"
                                                                        data-id="{{ $item->id }}"><i
                                                                            class="fas fa-trash"></i>
                                                                        Delete</a></li>
                                                            </form>
                                                        </ul>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $serviceStrategy->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>

    @include('admin.sett_company_profile.ServiceStrategy.components.modal_add_service_strategy')
    @include('admin.sett_company_profile.ServiceStrategy.components.modal_edit_service_strategy')


@section('script')
    @include('admin.sett_company_profile.ServiceStrategy.components.script')
@endsection
@endsection
