@extends('frontend.layout.master')
@section('title')
    All User
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>All User</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">User Management</h3>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <button href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#add_user"><i class="fa fa-plus"></i> Add User</button>
                            </div>
                        </div>
                    </div>
                    @include('sweetalert::alert')
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                use Carbon\Carbon;
                            @endphp
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>User ID</th>
                                        {{-- <th></th> --}}
                                        <th>Email</th>
                                        <th>Join Date</th>
                                        <th>Last Login</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $key => $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col">
                                                            <span hidden class="image">{{ $user->avatar }}</span>
                                                            <img class="avatar"
                                                                src="{{ URL::to('/admin/assets/img/avatar/' . $user->avatar) }}"
                                                                alt="{{ $user->avatar }}" width="25px">
                                                        </div>
                                                        <div class="col">
                                                            <span class="name">{{ $user->name }}</span>
                                                            <p hidden class="ids">{{ $user->id }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="id">{{ $user->user_id }}</td>
                                            <td class="email">{{ $user->email }}</td>
                                            <td>{{ $user->join_date }}</td>
                                            <td>{{ Carbon::parse($user->last_login)->diffForHumans() }}</td>
                                            <td style="max-width: 150px;">
                                                @if ($user->role_name == 'Admin')
                                                    <span class="badge badge-success role_name text-truncate d-inline-block"
                                                        style="max-width: 120px;">
                                                        {{ $user->role_name }}
                                                    </span>
                                                @elseif ($user->role_name == 'Super Admin')
                                                    <span class="badge badge-warning role_name text-truncate d-inline-block"
                                                        style="max-width: 120px;">
                                                        {{ $user->role_name }}
                                                    </span>
                                                @elseif ($user->role_name == 'Administrator Developer')
                                                    <span class="badge badge-danger role_name text-truncate d-inline-block"
                                                        style="max-width: 140px;">
                                                        {{ $user->role_name }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge badge-secondary role_name text-truncate d-inline-block"
                                                        style="max-width: 120px;">
                                                        {{ $user->role_name }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($user->status == 'Active')
                                                    <span class="badge badge-success statuss">{{ $user->status }}</span>
                                                @elseif ($user->status == 'Inactive')
                                                    <span class="badge badge-warning statuss">{{ $user->status }}</span>
                                                @elseif ($user->status == 'Disable')
                                                    <span class="badge badge-danger statuss">{{ $user->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        More Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item userUpdate" data-toggle="modal"
                                                                data-id="'.$user->id.'" data-target="#edit_user"><i
                                                                    class="fas fa-pen-square"></i> Edit</a></li>
                                                        <li><a class="dropdown-item userDelete" data-toggle="modal"
                                                                data-id="'.$user->id.'" data-target="#delete_user"><i
                                                                    class="fas fa-trash"></i> Delete</a></li>
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

    @include('admin.user_management.components.modal_add_user')
    @include('admin.user_management.components.modal_edit_user')
    @include('admin.user_management.components.modal_delete_user')


@section('script')
    <script>
        $(document).on('click', '.userUpdate', function() {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#e_name').val(_this.find('.name').text());
            $('#e_email').val(_this.find('.email').text());
            $('#e_phone_number').val(_this.find('.phone_number').text());
            $('#e_image').val(_this.find('.image').text());

            var name_role = (_this.find(".role_name").text());
            var _option = '<option selected value="' + name_role + '">' + _this.find('.role_name').text() +
                '</option>'
            $(_option).appendTo("#e_role_name");

            var statuss = (_this.find(".statuss").text());
            var _option = '<option selected value="' + statuss + '">' + _this.find('.statuss').text() + '</option>'
            $(_option).appendTo("#e_status");

        });
    </script>
    <script>
        $(document).on('click', '.userDelete', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('.e_avatar').val(_this.find('.image').text());
        });
    </script>
@endsection
@endsection
