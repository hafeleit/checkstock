@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Role Permissions'])

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn active"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if (session('status'))
            <div class="alert-status"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
        @endif

        <div class="eu-card">
            <div class="eu-card-header">
                <div>
                    <p class="eu-card-title">Assign Permissions</p>
                    <p class="eu-card-subtitle">Role: {{ $role->name }}</p>
                </div>
            </div>

            <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="eu-card-body">
                    @error('permission')
                        <p class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror

                    <?php $titleStore = ''; ?>
                    @foreach ($permissions as $permission)
                        <?php
                        $parts = explode(' ', $permission->name);
                        $group = $parts[0];
                        $label = implode(' ', array_slice($parts, 1));
                        ?>
                        @if ($titleStore !== $group)
                            <?php $titleStore = $group; ?>
                            @if (!$loop->first)
                </div>
        </div>
        @endif
        <div class="mb-4">
            <div class="perm-group-title">{{ $group }}</div>
            <div class="row g-1">
                @endif
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label class="perm-check-label">
                        <input type="checkbox" name="permission[]" value="{{ $permission->name }}"
                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        <span>{{ $label ?: $permission->name }}</span>
                    </label>
                </div>
                @endforeach
                @if (count($permissions) > 0)
            </div>
        </div>
        @endif
    </div>

    <div class="eu-card-footer">
        <a href="{{ url('roles') }}" class="btn-eu-secondary">
            <i class="fas fa-arrow-left fa-xs"></i> Back
        </a>
        <button type="submit" class="btn-eu-primary">
            <i class="fas fa-check fa-xs"></i> Update Permissions
        </button>
    </div>
    </form>
    </div>
    </div>
@endsection
