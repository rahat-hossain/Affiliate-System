@extends('backend.layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Order List
                    </div>
                    <div class="card-body table-responsive">
                        @if (session('deletestatus'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('deletestatus') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table class="table table-bordered table-hover" id="">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Tax (%)</th>
                                    <th>Package Discount Price</th>
                                    <th>Coupon Code</th>
                                    <th>Coupon Amount</th>
                                    <th>Customer  Name</th>
                                    <th>Customer Phone</th>
                                    <th>Order Time & Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($invoiceDetails as $invoiceDetail)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $invoiceDetail->ProductTable->name }}</td>
                                    <td>{{ $invoiceDetail->ProductTable->unit_price }} Tk.</td>
                                    <td>{{ $invoiceDetail->vat_tax }} %</td>
                                    <td>{{ $invoiceDetail->cash_discount }} Tk.</td>
                                    <td>{{ $invoiceDetail->InvoiceTable->coupon_code ?? 'Null'}}</td>
                                    <td>{{ $invoiceDetail->InvoiceTable->coupon_amount ?? '0'}}</td>
                                    <td>{{ $invoiceDetail->InvoiceTable->UserTable->name }}</td>
                                    <td>{{ $invoiceDetail->InvoiceTable->UserTable->phone }}</td>
                                    <td>{{ $invoiceDetail->created_at }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/invoice') }}/{{ $invoiceDetail->id }}" class="btn btn-info" target="_blank">Print invoice</a>
                                            <a href="{{ url('admin/order/delete') }}/{{ $invoiceDetail->id }}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center text-danger">No Data Available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
