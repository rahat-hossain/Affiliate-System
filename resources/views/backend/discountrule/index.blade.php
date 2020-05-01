@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Discount Rules List
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
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Discount Unit</th>
                                <th>Min Quantity/Duration</th>
                                <th>Max Quantity/Duration</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($discountrules as $discountrule)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $discountrule->discount_unit }}</td>
                                    <td>{{ $discountrule->min }}</td>
                                    <td>{{ $discountrule->max }}</td>
                                    <td>{{ $discountrule->percentage }}</td>
                                    <td>
                                        @if( $discountrule->status == '1')
                                            <a href="{{ url('admin/discountrule/active') }}/{{ $discountrule->id }}">
                                                <span class="badge badge-success">Active</span>
                                            </a>
                                        @else
                                            <a href="{{ url('admin/discountrule/deactive') }}/{{ $discountrule->id }}">
                                                <span class="badge badge-danger">Dective</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/discountrule/edit') }}/{{ $discountrule->id }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('admin/discountrule/delete') }}/{{ $discountrule->id }}" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>
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
                        Add Discount Rules
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
                        <form method="post" action="{{ url('admin/discountrule/insert') }}">
                            @csrf
                            <div class="form-group">
                                <label>Discount Unit</label>
                                <select class="form-control" name="discount_unit">
                                    <option value="">- select one -</option>
                                        <option value="quantity">quantity</option>
                                        <option value="days">days</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>minimum</label>
                                <input type="text" class="form-control" name="min">
                                @error('min')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Maximum</label>
                                <input type="text" class="form-control" name="max">
                                @error('max')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Percentage</label>
                                <input type="text" class="form-control" name="percentage">
                                @error('percentage')
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
                            <button type="submit" class="btn btn-success">Add Discount Rule</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
