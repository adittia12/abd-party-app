@extends('frontend.layout.master')
@section('title')
    Master | Group
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Group</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal" data-target="#add_group"><i
                                        class="fa fa-plus"></i> Tambah Data</button>
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
                                <form id="searchForm" action="{{ route('group.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pencarian" name="q"
                                            value="{{ request('q') }}" id="searchQuery" autofocus>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" id="groupTableContainer">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Group</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataGroup->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <span class="badge badge-danger">Data masih kosong</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataGroup as $key => $item)
                                            <tr>
                                                <td>{{ $dataGroup->perPage() * ($dataGroup->currentPage() - 1) + $key + 1 }}
                                                </td>
                                                <td class="code_id_group" hidden>{{ Crypt::encrypt($item->id) }}</td>
                                                <td class="name_group">{{ $item->name_group }}</td>
                                                <td class="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            More Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item groupUpdate" data-toggle="modal"
                                                                    data-id="'.$item->id.'" data-target="#edit_group"><i
                                                                        class="fas fa-pen-square"></i> Edit</a></li>
                                                            <form
                                                                action="{{ route('group.destroy', Crypt::encrypt($item->id)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li><a class="dropdown-item delete-button"
                                                                        data-id="{{ Crypt::encrypt($item->id) }}"><i
                                                                            class="fas fa-trash"></i>
                                                                        Delete</a></li>
                                                            </form>
                                                        </ul>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $dataGroup->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('master.groups.components.modal_add_product')
    @include('master.groups.components.modal_edit_product')


@section('script')
    @include('master.groups.components.script')
@endsection
@endsection
