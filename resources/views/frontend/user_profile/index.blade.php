@extends('frontend.layouts.frontend_master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header">
                        User Profile
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
                        <center>
                            @php
                                $profile_photo = App\Profile::where('user_id', auth()->user()->id)->first();

                            @endphp
                            <div class="span2">
                                <img src="{{ asset('uploads/users_photos') }}/{{ $profile_photo->photo ?? '' }}" height="200 px" width="170 px" alt="" class="img-rounded">
                            </div>
                        </center>
                            <div class="span4">
                                <blockquote>
                                    <center><h4 class="mb-5">{{ auth()->user()->name }}</h4></center>
                                    <p><b>Email :</b> {{ auth()->user()->email }}</p>
                                    <p><b>Address :</b> {{ $profile_photo->address ?? '' }}</p>
                                    <p><b>Phone :</b> {{ auth()->user()->phone }}</p>
                                    <p><b>Alternate Phone :</b> {{ $profile_photo->alternate_phone ?? '' }}</p>
                                    <p><b>Refered To :</b>  <span class="badge badge-success">{{ auth()->user()->referrals->count() }}</span> </p>
                                    <p><b>Referal Bonus :</b> {{ auth()->user()->referrals->count() * 10 }} Tk</p>
                                    <p><b>Refered By :</b>  <span class="badge badge-success">{{ $refarar_name ?? 'N/A' }}</span></p>
                                    <p><b>Refered Link :</b> <span>{{ Auth::user()->referral_link }}</span>  </p>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5">
                <div class="card">
                    <div class="card-header">
                        Edit Profile
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
                        <form method="post" action="{{ url('user/profile/edit') }}/{{ auth()->user()->id }}" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" class="form-control" name="name">
                                <input type="hidden"  name="user_id" value="{{ auth()->user()->id }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" value="{{ auth()->user()->email }}" class="form-control" name="email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" value="{{ $profile_photo->address ?? '' }}" class="form-control" name="address">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alternate Phone</label>
                                <input type="text" class="form-control" value="{{ $profile_photo->alternate_phone ?? '' }}" name="alternate_phone">
                                @error('alternate_phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


