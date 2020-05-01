@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        Edit Packages
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
                        <form method="post" action="{{ url('admin/packages/edit') }}/{{ $packages_info->id }}">
                            @csrf
                            <div class="form-group">
                                <label>Product name</label>
                                <select class="form-control" name="product_id">
                                    <option value="">- select one -</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ ($packages_info->product_id == $product->id) ? "selected":"" }} >{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount rule</label>
                                <select class="form-control" name="discount_rule_id">
                                    <option value="">- select one -</option>
                                    @foreach($discountrules as $discountrule)
                                        <option value="{{ $discountrule->id }}" {{ ($packages_info->discount_rule_id == $discountrule->id) ? "selected":"" }} >{{ $discountrule->min .'-'. $discountrule->max .' '. $discountrule->discount_unit .' = '. $discountrule->percentage .'%' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" value="{{ $packages_info->price }}">
                                @error('price')
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

