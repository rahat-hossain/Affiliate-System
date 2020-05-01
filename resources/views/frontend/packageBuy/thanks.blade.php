@extends('frontend.layouts.frontend_master')

@section('title', 'Order complete')

@push('css')


@endpush


@section('content')


    <div class="container mt-4">
        <h1 class="alert alert-success text-center">Thanks for your order ! <br>
            <small style="font-size: 15px">We will contact you as soon as prosible.</small>
            <a type="button" href="{{ '/' }}" class="btn btn-success">Continue Shopping...</a>
        </h1>

    </div>

@endsection



@push('script')

@endpush
