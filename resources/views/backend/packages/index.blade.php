@extends('backend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Packages List
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
                        <table class="table table-bordered table-hover" id="slider_table">
                            <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product Name</th>
                                <th>Discount info (-)</th>
                                <th>Tax (+)</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($packages as $package)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $package->relationToProductTable->name ?? '' }}</td>
                                    <td>
                                        {{ $package->relationToDiscountRulesTable->min ?? '' }}-
                                        {{ $package->relationToDiscountRulesTable->max  ?? ''}}
                                        {{ $package->relationToDiscountRulesTable->discount_unit ?? '' }}=
                                        {{ $package->relationToDiscountRulesTable->percentage  ?? ''}}%
                                    </td>
                                    <td>{{ $package->tax_percentage }}%</td>
                                    <td>{{ $package->price }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('admin/packages/edit') }}/{{ $package->id }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('admin/packages/delete') }}/{{ $package->id }}" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>
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
                        Add Packages
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
                        <form method="post" action="{{ url('admin/packages/insert') }}">
                            @csrf
                            <div class="form-group">
                                <label>Product name</label>
                                <select class="form-control" name="product_id" id="product_id">
                                    <option value="">- select one -</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}.{{ $product->unit_price }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount rule</label>
                                <select class="form-control" name="discount_rule_id" id="discount_rule_id">
                                    <option value="">- select one -</option>
                                    @foreach($discountrules as $discountrule)
                                        <option value="{{ $discountrule->id }}.{{ $discountrule->percentage }}">{{ $discountrule->min .'-'. $discountrule->max .' '. $discountrule->discount_unit .' = '. $discountrule->percentage .'%' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tax Percentage(%)</label>
                                <input type="text" class="form-control" id="tax_percentage" name="tax_percentage" placeholder="only type the % value">
                                @error('tax_percentage')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" value="" id="discount_price" name="price" readonly>
                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Add Packages</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')

   <script>
       $(document).ready(function()
       {
           $("#product_id").change(function()
           {
               var selectedProductVal = $("#product_id option:selected").val();
               var unitPrice = selectedProductVal.split(".").pop(-1);

               var selectedDiscountVal = $("#discount_rule_id option:selected").val();
               var percentage = selectedDiscountVal.split(".").pop(-1);

               var taxValue = $("#tax_percentage").val();

               var totalprice = calculateTotalPriceWithDiscount(percentage, unitPrice, taxValue);
               $("#discount_price").val(totalprice);
           });

           $("#discount_rule_id").change(function()
           {
               var selectedDiscountVal = $("#discount_rule_id option:selected").val();
               var percentage = selectedDiscountVal.split(".").pop(-1);

               var selectedProductVal = $("#product_id option:selected").val();
               var unitPrice = selectedProductVal.split(".").pop(-1);

               var taxValue = $("#tax_percentage").val();

               var totalprice = calculateTotalPriceWithDiscount(percentage, unitPrice, taxValue);
               $("#discount_price").val(totalprice);

           });


           $("#tax_percentage").change(function () {
                var taxValue = $("#tax_percentage").val();

               var selectedDiscountVal = $("#discount_rule_id option:selected").val();
               var percentage = selectedDiscountVal.split(".").pop(-1);

               var selectedProductVal = $("#product_id option:selected").val();
               var unitPrice = selectedProductVal.split(".").pop(-1);

               var totalprice = calculateTotalPriceWithDiscount(percentage, unitPrice, taxValue);
               $("#discount_price").val(totalprice);
           });

           function calculateTotalPriceWithDiscount(percentage, unitPrice, taxValue) {
               var withoutTaxPrice = unitPrice - (unitPrice *percentage/100);
               var price = withoutTaxPrice + (taxValue * withoutTaxPrice / 100);
               return price;
           }

       });
    </script>

@endsection
