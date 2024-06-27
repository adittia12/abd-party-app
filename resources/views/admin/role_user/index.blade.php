@extends('frontend.layout.master')
@section('title')
    Admin | Role User
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Data Role User</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">List Role User</h3>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#add_role"><i class="fa fa-plus"></i> Add Role</button>
                            </div>
                        </div>
                    </div>
                    @include('sweetalert::alert')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($role as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="role_type">{{ $item->role_type }}</td>
                                            <td class="id_role" hidden>{{ $item->id }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        More Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item roleUpdate" data-toggle="modal"
                                                                data-id="'.$item->id.'" data-target="#edit_role"><i
                                                                    class="fas fa-pen-square"></i> Edit</a></li>
                                                        <form action="{{ route('user_role.destroy', $item->id) }}"
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.role_user.components.modal_add_role')
    @include('admin.role_user.components.modal_edit_role')


@section('script')
    <script>
        $(document).on('click', '.roleUpdate', function() {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id_role').text());
            $('#e_role_type').val(_this.find('.role_type').text());
        });
    </script>
    @include('admin.role_user.components.script')
@endsection
@endsection
