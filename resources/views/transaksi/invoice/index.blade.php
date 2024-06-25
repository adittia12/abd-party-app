@extends('frontend.layout.master')
@section('title')
    Transaksi | Invoice
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Invoice</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mt-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="">Invoice list</h3>
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
                                        <th>Nama Customer</th>
                                        <th>No Invoice</th>
                                        <th>Periode Date</th>
                                        <th>No PO</th>
                                        <th>Doc Konsumen</th>
                                        <th>Doc Kantor</th>
                                        <th>Doc Karyawan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="order_number">{{ $item->order_number }}}</span></td>
                                            <td class="name_customer">{{ $item->name_customer }}</td>
                                            <td class="invoice_number">{{ $item->invoice_number }}</td>
                                            <td class="period_date">
                                                {{ \Carbon\Carbon::parse($item->period_date)->translatedFormat('F Y') }}
                                            </td>
                                            <td class="no_po_manual">
                                                @if ($item->no_po_manual)
                                                    {{ $item->no_po_manual }}
                                                @elseif (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
                                                    <button type="button" class="btn btn-success btn-sm rounded-full"
                                                        data-toggle="modal" data-target="#createPo"
                                                        data-invoice-id="{{ $item->id }}">
                                                        Create PO
                                                    </button>
                                                @else
                                                    <span class="badge badge-danger">Tidak ada Nomor PO</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('invoice.doc-konsumen', Crypt::encrypt($item->id)) }}"
                                                    class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i> Doc Konsumen
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('invoice.doc-kantor', Crypt::encrypt($item->id)) }}"
                                                    class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i> Doc Kantor
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('invoice.docEmployee', Crypt::encrypt($item->id)) }}"
                                                    class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i> Doc Karyawan
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-info dropdown-toggle btn-sm"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                More Action
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('invoice.show', Crypt::encrypt($item->id)) }}"><i
                                                                            class="fas fa-file-invoice"></i>
                                                                        Invoice</a></li>
                                                                <li><a class="dropdown-item invoiceUpdate"
                                                                        data-toggle="modal"
                                                                        data-id="'{{ str_replace('/', '-', $item->invoice_number) }}"
                                                                        data-target="#edit_invoice"><i
                                                                            class="fas fa-pen-square"></i> Edit</a></li>
                                                                @if (Auth::user()->role_name == 'Admin')
                                                                    <form
                                                                        action="{{ route('invoice.destroy', $item->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <li><a class="dropdown-item delete-button"
                                                                                data-id="{{ $item->id }}"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Delete</a></li>
                                                                    </form>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
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

    @include('transaksi.invoice.components.modal.modal_create_po')
    @include('transaksi.invoice.components.modal.modal_edit_invoice')
@section('script')
    @include('transaksi.invoice.components.js.script')
@endsection
@endsection
