@extends('frontend.layout.master')
@section('title')
    Activity Log
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Activity Log</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-center">Activity Log</h5>
                                </div>
                            </div>
                        </div>
                        @include('sweetalert::alert')
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activityLog as $key => $item)
                                        <tr>
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->date_time }}</td>
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
@endsection
