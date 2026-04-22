@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Permission'])

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn active"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if ($errors->any())
            <div class="eu-errors eu-card-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="eu-card eu-card-sm">
            <div class="eu-card-header">
                <div>
                    <p class="eu-card-title">Edit Permission</p>
                    <p class="eu-card-subtitle">{{ $permission->name }}</p>
                </div>
            </div>
            <form action="{{ url('permissions/' . $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="eu-card-body">
                    <div class="eu-group">
                        <label class="eu-label">Permission Name <span class="required-dot">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="eu-input"
                            required>
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="eu-card-footer">
                    <a href="{{ url('permissions') }}" class="btn-eu-secondary">
                        <i class="fas fa-arrow-left fa-xs"></i> Back
                    </a>
                    <button type="submit" class="btn-eu-primary">
                        <i class="fas fa-check fa-xs"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
