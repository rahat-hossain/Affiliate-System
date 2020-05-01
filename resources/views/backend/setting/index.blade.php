@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Shipping charge List
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
                                    <th>Parameter</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse ($settings as $setting)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $setting->parameter }}</td>
                                    <td>{{ $setting->value }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/setting/edit') }}/{{ $setting->id }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('admin/setting/delete') }}/{{ $setting->id }}" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                        Add Shipping
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
                        <form method="post" action="{{ url('admin/setting/insert') }}">
                            @csrf
                            <div class="form-group">
                                <label>Parameter</label>
                                <input type="text" class="form-control" value="" id="parameter" name="parameter">
                                @error('parameter')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input type="text" class="form-control" value="" id="value" name="value">
                                @error('value')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Add Shipping</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')

@endsection
