@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        Edit Discount rules
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
                        <form method="post" action="{{ url('admin/discountrule/edit') }}/{{ $discountrule_info->id }}">
                            @csrf
                            <div class="form-group">
                                <label>Discount unit</label>
                                    <select class="form-control" name="discount_unit">
                                        <option value="">- select one -</option>
                                        <option value="quantity" {{ ($discountrule_info->discount_unit == 'quantity') ? "selected":"" }}>quantity</option>
                                        <option value="days" {{ ($discountrule_info->discount_unit == 'days') ? "selected":"" }}>days</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label>Minimum</label>
                                <input type="text" class="form-control" name="min" value="{{ $discountrule_info->min }}">
                                @error('min')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Maximun</label>
                                <input type="text" class="form-control" name="max" value="{{ $discountrule_info->max }}">
                                @error('max')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Percentage</label>
                                <input type="text" class="form-control" name="percentage" value="{{ $discountrule_info->percentage }}">
                                @error('percentage')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
