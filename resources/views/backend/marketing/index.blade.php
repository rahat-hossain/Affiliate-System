@extends('backend.layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Marketings List
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover" id="slider_table">
                            <thead>
                            <tr>
                                <th>SL No</th>
                                <th>New User</th>
                                <th>Referal Code</th>
                                <th>Referred By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($marketings as $marketing)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $marketing->referrer->name }} ({{ $marketing->referrer->phone }})</td>
                                    <td>{{ $marketing->referal_code }}</td>
                                    <td>{{ $marketing->relForReferedBy->name }} ({{ $marketing->relForReferedBy->phone }})</td>
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
        </div>
    </div>
@endsection
