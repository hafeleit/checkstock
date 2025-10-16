@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/avatar.png" alt="profile_image" class="w-100 border-radius-lg">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Public Relations
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>

                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="username"
                                            value="{{ old('username', auth()->user()->username) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email"
                                            value="{{ old('email', auth()->user()->email) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name</label>
                                        <input class="form-control" type="text" name="firstname"
                                            value="{{ old('firstname', auth()->user()->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input class="form-control" type="text" name="lastname"
                                            value="{{ old('lastname', auth()->user()->lastname) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', auth()->user()->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City</label>
                                        <input class="form-control" type="text" name="city"
                                            value="{{ old('city', auth()->user()->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country</label>
                                        <input class="form-control" type="text" name="country"
                                            value="{{ old('country', auth()->user()->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code</label>
                                        <input class="form-control" type="text" name="postal"
                                            value="{{ old('postal', auth()->user()->postal) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Country</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country</label>
                                        <select class="form-control" name="about" data-toggle="select"
                                            title="Simple select" data-live-search="true"
                                            data-live-search-placeholder="Search ...">
                                            <option value="HTH" {{ auth()->user()->about == 'HTH' ? 'selected' : '' }}>
                                                HTH</option>
                                            <option value="HVN" {{ auth()->user()->about == 'HVN' ? 'selected' : '' }}>
                                                HVN</option>
                                            <option value="HSI" {{ auth()->user()->about == 'HSI' ? 'selected' : '' }}>
                                                HSI</option>
                                            <option value="HIN" {{ auth()->user()->about == 'HIN' ? 'selected' : '' }}>
                                                HIN</option>
                                            <option value="HSR" {{ auth()->user()->about == 'HSR' ? 'selected' : '' }}>
                                                HSR</option>
                                            <option value="HMA" {{ auth()->user()->about == 'HMA' ? 'selected' : '' }}>
                                                HMA</option>
                                            <option value="HRI" {{ auth()->user()->about == 'HRI' ? 'selected' : '' }}>
                                                HRI</option>
                                            <option value="HPI" {{ auth()->user()->about == 'HPI' ? 'selected' : '' }}>
                                                HPI</option>
                                            <option value="HTW" {{ auth()->user()->about == 'HTW' ? 'selected' : '' }}>
                                                HTW</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="text-uppercase text-sm">Supplier</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Supplier code</label>
                                        <input class="form-control" type="text" name="supp_code"
                                            value="{{ old('postal', auth()->user()->supp_code) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end align-items-center px-0">
                                <a href="{{ route('change-password') }}" type="button"
                                    class="btn btn-dark btn-sm me-2 mb-0">
                                    Change Password
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm mb-0">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
