@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Product List
                    </div>
                    <div class="card-body table-responsive">
                        @if (session('editstatus'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                {{ session('editstatus') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (session('deletestatus'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('deletestatus') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table class="table table-bordered table-hover" id="#">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img width="80" height="60" src="{{ asset('uploads/product_photos') }}/{{ $product->photo }}" alt="not found">
                                    </td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->unit_price }}</td>
                                    <td>
                                        @if( $product->status == '1')
                                            <a href="{{ url('admin/product/active') }}/{{ $product->id }}">
                                                <span class="badge badge-success">Active</span>
                                            </a>
                                        @else
                                            <a href="{{ url('admin/product/deactive') }}/{{ $product->id }}">
                                                <span class="badge badge-danger">Dective</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/product/edit') }}/{{ $product->id }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('admin/product/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No Data Available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Add Product
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form method="post" action="{{ url('admin/product/insert') }}" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label>product name</label>
                                <input type="text" class="form-control" name="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" class="form-control" name="photo">
                                @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="unit">
                                @error('unit')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Unit Price</label>
                                <input type="text" class="form-control" name="unit_price">
                                @error('unit_price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="checkbox" value="1" name="status">
                                @error('status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
