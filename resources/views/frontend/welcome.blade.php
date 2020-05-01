@extends('frontend.layouts.frontend_master')
@section('content')
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" height="600px" src="{{ asset('frontend_assets/slider_image/slider1.png') }}" alt="First slide">
            </div>
        </div>
    </div>


{{-- ---------------------products start------------ --}}
{{--    <section id="products">--}}
{{--        <div class="container">--}}
{{--            <h2 class="mb-5 mt-5 text-center">Our Products</h2>--}}
{{--            <div class="row">--}}
{{--                <div class="owl-carousel owl-theme mb-2">--}}
{{--                    @foreach($products as $product)--}}
{{--                    <div class="item">--}}
{{--                        <a href="">--}}
{{--                            <h4><img src="{{ asset('uploads/product_photos') }}/{{ $product->photo }}" alt=""></h4>--}}
{{--                        </a>--}}
{{--                        <p style="margin-bottom: 0"><b>Name: </b> {{ $product->name }}</p>--}}
{{--                        <p style="margin-bottom: 0"><b>Price: </b> {{ $product->unit_price }}</p>--}}
{{--                        <p style="margin-bottom: 0"><b>Unit: </b> {{ $product->unit }}</p>--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    {{-- ---------------------products end------------ --}}

    {{-- ---------------------package start------------ --}}
    <section id="packages">
        <div class="container">
            <h2 class="mb-5 mt-5 text-center">Packages</h2>
            <div class="row">
                <div class="owl-carousel owl-theme mb-2">
                        @foreach($packages as $package)
                        <div class="item">
                            <a href="">
                                <h4><img src="{{ asset('uploads/product_photos') }}/{{ $package->relationToProductTable->photo ?? '' }}" alt=""></h4>
                            </a>
                            <center>
                                <p style="margin-bottom: 0"> {{ $package->relationToProductTable->name ?? '' }} </p>
                                <p style="margin-bottom: 3px"> <h3> Save {{ $package->relationToDiscountRulesTable->percentage ?? '' }}% </h3> </p>
                                <p style="margin-bottom: 2px">
                                        {{ $package->relationToDiscountRulesTable->min }} -
                                        {{ $package->relationToDiscountRulesTable->max }}
                                        {{ $package->relationToDiscountRulesTable->discount_unit }}
                                </p>
                                <p style="margin-bottom: 0"> Original Price : <del>{{ $package->relationToProductTable->unit_price ?? '' }} Taka</del></p>
                                <p style="margin-bottom: 0"> <h5> {{ $package->price ?? '' }} Tk</h5> </p>
                            </center>
                            <a type="button" href="{{ url('package/buy') }}/{{ $package->id }}" style="background: #de9c9d" class="btn btn-outline-dark btn-lg btn-block mt-3 mb-3">Buy</a>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- ---------------------package end------------ --}}


    @endsection

