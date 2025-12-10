@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Change password</h4>
                                    <p class="mb-0">Set a new password for your email</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="post" action="{{ route('change.perform') }}">
                                        @csrf
                                        @method('put')
                                        <div class="mb-3">
                                          <input type="hidden" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                                          <input type="text" class="form-control form-control-lg" placeholder="Email"
                                            value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" aria-label="Email" readonly>
                                            @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Current Password" aria-label="Password" autocomplete="off">
                                            @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" name="new_password" class="form-control form-control-lg" placeholder="New Password" aria-label="Password" autocomplete="off">
                                            @error('new_password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" name="new_password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password" autocomplete="off">
                                            @error('new_password_confirmation') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Change Password</button>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{Route('profile')}}" class="btn btn-lg btn-secondary btn-lg w-100 mt-4 mb-0">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                                <div id="alert">
                                    @include('components.alert')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
