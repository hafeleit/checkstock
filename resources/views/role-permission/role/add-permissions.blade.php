@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Role Permissions'])

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        * {
            box-sizing: border-box;
        }

        .eu-container {
            padding-top: 15rem;
            padding-bottom: 2rem;
        }

        .eu-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .eu-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 10px;
            font-size: 0.81rem;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #4a4a4a;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }

        .eu-nav-btn:hover {
            background: #f4f5f7;
            border-color: #bbb;
            color: #1a1a1a;
        }

        .eu-nav-btn.active {
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(200, 16, 46, 0.25);
        }

        .eu-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .eu-card-header {
            padding: 20px 28px 16px;
            border-bottom: 1px solid #f2f2f2;
        }

        .eu-card-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0;
        }

        .eu-card-subtitle {
            font-size: 0.78rem;
            color: #9ca3af;
            margin: 2px 0 0;
        }

        .eu-card-body {
            padding: 24px 28px 8px;
        }

        .perm-group-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: #C8102E;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            padding-bottom: 8px;
            margin-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .perm-group-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        .perm-check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
            font-size: 0.82rem;
            color: #1a1a1a;
            border: 1px solid transparent;
        }

        .perm-check-label:hover {
            background: #fafafa;
            border-color: #f0f0f0;
        }

        .perm-check-label input[type="checkbox"] {
            accent-color: #C8102E;
            width: 15px;
            height: 15px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .perm-check-label input[type="checkbox"]:checked+span {
            color: #C8102E;
            font-weight: 500;
        }

        .eu-card-footer {
            padding: 16px 28px 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-top: 1px solid #f2f2f2;
            margin-top: 8px;
        }

        .eu-card-footer .btn-eu-secondary,
        .eu-card-footer .btn-eu-primary {
            width: 100%;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .eu-card-footer {
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
            }

            .eu-card-footer .btn-eu-secondary,
            .eu-card-footer .btn-eu-primary {
                width: auto;
            }
        }

        .btn-eu-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            background: transparent;
            color: #4a4a4a;
            font-size: 0.83rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }

        .btn-eu-secondary:hover {
            background: #f4f5f7;
            border-color: #bbb;
            color: #1a1a1a;
        }

        .btn-eu-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 24px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            color: #fff;
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 16px rgba(200, 16, 46, 0.28);
        }

        .btn-eu-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-eu-primary:active {
            transform: translateY(0);
        }

        .alert-status {
            background: rgba(16, 185, 129, 0.07);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 0.84rem;
            color: #065f46;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .field-error {
            font-size: 0.75rem;
            color: #C8102E;
            margin-bottom: 12px;
        }
    </style>

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
