@extends('frontend.layout.master')
@section('title')
    Master | Karyawan
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Karyawan</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <!-- Tombol Tambah Data -->
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_employe">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </button>
                            </div>
                            <!-- Tombol Import -->
                            <div class="col-auto">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#import-employe">
                                    <i class="fa fa-file-import"></i> Import
                                </button>
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
                                <form id="searchForm" action="{{ route('employe.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="employeTableContainer">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Nama Group</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataEmploye->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <span class="badge badge-danger">Data masih kosong</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataEmploye as $key => $item)
                                            <tr>
                                                <td>{{ $dataEmploye->perPage() * ($dataEmploye->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td class="code_employe">{{ $item->code_employe }}</td>
                                                <td class="name">{{ $item->name }}</td>
                                                <td class="name_group">{{ $item->name_group }}</td>
                                                <td class="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            More Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item employeUpdate" data-toggle="modal"
                                                                    data-target="#edit_employe">
                                                                    <i class="fas fa-pen-square"></i> Edit
                                                                </a></li>
                                                            <form
                                                                action="{{ route('employe.destroy', Crypt::encrypt($item->code_employe)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li><a class="dropdown-item delete-button"
                                                                        data-id="{{ Crypt::encrypt($item->code_employe) }}">
                                                                        <i class="fas fa-trash"></i> Delete
                                                                    </a></li>
                                                            </form>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $dataEmploye->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('master.employe.components.modal_add_employe')
    @include('master.employe.components.modal_edit_employe')
    @include('master.employe.components.modal_import_emp')


@section('script')
    @include('master.employe.components.script')

    <!-- Tambahkan script untuk memperbarui nama file yang dipilih -->
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            let fileName = e.target.files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection
@endsection
