@extends('frontend.layout.master')
@section('title')
    Set CP | Pelayanan
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Pelayanan</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#add_service"><i class="fa fa-plus"></i> Tambah Pelayanan</button>
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
                                <form id="searchForm" action="{{ route('service.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="serviceTableContainer">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pelayanan</th>
                                            <th>Slug</th>
                                            <th>Description</th>
                                            <th>Gambar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceData as $key => $item)
                                            <tr>
                                                <td>{{ $serviceData->perPage() * ($serviceData->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td hidden class="id_updateservice">{{ Crypt::encrypt($item->service_id) }}
                                                </td>
                                                <td class="title">{{ $item->title }}</td>
                                                <td class="slug_service">{{ $item->slug }}</td>
                                                <td class="description">{{ $item->description }}</td>
                                                <td class="image">
                                                    <img src="{{ asset('storage/' . $item->name_photo) }}" alt="Image"
                                                        class="img-thumbnail img-fluid rounded shadow-sm"
                                                        style="max-width: 120px;">
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            More Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item serviceUpdate" data-toggle="modal"
                                                                    data-id="'.$item->slug.'" data-target="#edit_service"><i
                                                                        class="fas fa-pen-square"></i> Edit</a></li>
                                                            <form action="{{ route('service.destroy', $item->slug) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li><a class="dropdown-item delete-button"
                                                                        data-id="{{ $item->slug }}"><i
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
                                {{ $serviceData->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>

    @include('admin.sett_company_profile.service.components.modal_add_service')
    @include('admin.sett_company_profile.service.components.modal_edit_service')


@section('script')
    <script>
        document.getElementById('title').addEventListener('input', function() {
            var title = this.value;
            var slug = title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
    <script>
        document.getElementById('e_title').addEventListener('input', function() {
            var title = this.value;
            var slug = title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            document.getElementById('e_slug_service').value = slug;
        });
    </script>
    @include('admin.sett_company_profile.service.components.script')
@endsection
@endsection
