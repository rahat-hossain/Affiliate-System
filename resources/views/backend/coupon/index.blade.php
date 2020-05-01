@extends('backend.layouts.app')
@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Coupon List
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
                        <table class="table table-bordered table-hover" id="">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Coupon Title</th>
                                    <th>Code</th>
                                    <th>Value</th>
                                    <th>Expire Date</th>
                                    <th>For</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $coupon->title }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->value }}</td>
                                    <td>{{ $coupon->expire_date }}</td>
                                    @if($coupon->for == 0)
                                        <td>All</td>
                                    @else
                                        <td>{{ $coupon->relationToUser->name }}</td>
                                    @endif

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/coupon/edit') }}/{{ $coupon->id }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('admin/coupon/delete') }}/{{ $coupon->id }}" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                        Add Coupon
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
                        @if($errors->all())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <form method="post" action="{{ url('admin/coupon/insert') }}">
                            @csrf

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" value="{{ Str::upper(Str::random(5)) }}">
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input type="text" class="form-control" name="value" placeholder="you can use flat amount or %">
                            </div>
                            <div class="form-group">
                                <label>Expire ( Date & Time )</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" name="validity_date">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="time" class="form-control" name="validity_time">
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label>For</label>
                                <select class="ui search dropdown form-control" name="for">
                                    <option value="">- Select User -</option>
                                    <option value="0">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Add Coupon</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')

@endsection
