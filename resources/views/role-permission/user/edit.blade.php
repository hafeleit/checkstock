@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Role'])

    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <p class="mb-0 font-weight-bold text-sm mt-3">

                          <a href="{{ url('roles') }}" class="btn btn-primary mx-1">Roles</a>
                          <a href="{{ url('permissions') }}" class="btn btn-info mx-1">Permissions</a>
                          <a href="{{ url('users') }}" class="btn btn-success mx-1">Users</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">

                @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit User
                            <a href="{{ url('users') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('users/'.$user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="username" value="{{ $user->username }}" class="form-control" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control" />
                                @error('email') <span class="text-danger">{{ $email }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password"  class="form-control" />
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Supplier Code</label>
                                <input type="text" name="supp_code" value="{{ $user->supp_code }}" class="form-control" />
                                @error('supp_code') <span class="text-danger">{{ $supp_code }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Roles</label>
                                <select name="roles[]" class="form-control" size="8" multiple>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option
                                        value="{{ $role }}"
                                        {{ in_array($role, $userRoles) ? 'selected':'' }}
                                    >
                                        {{ $role }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
