@extends('frontend.layout.master')
@section('title')
    Transaksi | Order
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Transaksi Order</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">Order list</h3>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="{{ route('order.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add
                                    Order</a>
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
                                        <th>Kode order</th>
                                        <th>Order Date</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal Pasang</th>
                                        <th>Mulai Acara</th>
                                        <th>Selesai Acara</th>
                                        <th>Status Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datasetOrder as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="order_number">{{ $item->order_number }}</td>
                                            <td class="order_date">{{ $item->order_date }}</td>
                                            <td class="name_customer">{{ $item->name_customer }}</td>
                                            <td class="date_pasang">{{ $item->date_pasang }}</td>
                                            <td class="start_event">{{ $item->start_event }}</td>
                                            <td class="end_event">{{ $item->end_event }}</td>
                                            <td class="status_order">
                                                {{ $item->status_order }}
                                                @if ($item->status_order === 'Pengajuan')
                                                    <span class="badge badge-secondary">{{ $item->status_order }}</span>
                                                @elseif ($item->status_order === 'Sudah ok')
                                                    <span class="badge badge-primary">{{ $item->status_order }}</span>
                                                @elseif ($item->status_order === 'Invoice')
                                                    <span class="badge badge-success">{{ $item->status_order }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        More Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($item->status_order === 'Pengajuan' || $item->status_order === 'Sudah ok')
                                                            <li><a class="dropdown-item productUpdate" data-toggle="modal"
                                                                    data-id="'.$item->id.'" data-target="#edit_product"><i
                                                                        class="fas fa-pen-square"></i> Edit</a></li>
                                                        @endif
                                                        <form action="{{ route('order.destroy', $item->id) }}"
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
@section('script')
@endsection
@endsection
