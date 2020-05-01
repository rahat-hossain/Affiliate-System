@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        Edit Coupon
                    </div>
                    @if($errors->all())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form method="post" action="{{ url('admin/coupon/edit') }}/{{ $coupon_info->id }}">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" value="{{ $coupon_info->title }}">
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" value="{{ $coupon_info->code }}">
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input type="text" class="form-control" name="value" value="{{ $coupon_info->value }}">
                            </div>
                            <div class="form-group">
                                <label>Expire ( Date & Time )</label>
                                @php
                                    $date = Str::before($coupon_info->expire_date, ' ');
                                    $time = Str::after($coupon_info->expire_date, ' ');
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="validity_date" value="{{ $date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="validity_time" value="{{ $time }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>For</label>
                                <select class="ui search dropdown form-control" name="for">
                                    <option value="">- Select User -</option>
                                    <option value="0">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($coupon_info->for == $user->id) ? "selected":"" }} >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
