@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => 'Create Role'])

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
            max-width: 560px;
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

        .eu-card-body {
            padding: 24px 28px 8px;
        }

        .eu-group {
            margin-bottom: 14px;
        }

        .eu-label {
            display: block;
            font-size: 0.74rem;
            font-weight: 500;
            color: #6D6E71;
            margin-bottom: 5px;
        }

        .eu-label .required-dot {
            color: #C8102E;
            margin-left: 2px;
        }

        .eu-input {
            width: 100%;
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            color: #1a1a1a;
            padding: 10px 14px;
            font-size: 0.86rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .eu-input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .field-error {
            font-size: 0.75rem;
            color: #C8102E;
            margin-top: 4px;
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

        .eu-errors {
            background: rgba(200, 16, 46, 0.06);
            border: 1px solid rgba(200, 16, 46, 0.18);
            border-left: 4px solid #C8102E;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 0.84rem;
            color: #C8102E;
            max-width: 560px;
        }

        .eu-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .eu-errors li {
            line-height: 1.8;
        }
    </style>

    <div class="container-fluid eu-container">
        <div class="eu-nav">
            <a href="{{ url('roles') }}" class="eu-nav-btn active"><i class="fas fa-shield-alt fa-xs"></i> Roles</a>
            <a href="{{ url('permissions') }}" class="eu-nav-btn"><i class="fas fa-key fa-xs"></i> Permissions</a>
            <a href="{{ url('users') }}" class="eu-nav-btn"><i class="fas fa-users fa-xs"></i> Users</a>
        </div>

        @if ($errors->any())
            <div class="eu-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="eu-card">
            <div class="eu-card-header">
                <p class="eu-card-title">Create Role</p>
            </div>
            <form action="{{ url('roles') }}" method="POST">
                @csrf
                <div class="eu-card-body">
                    <div class="eu-group">
                        <label class="eu-label">Role Name <span class="required-dot">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="eu-input" required>
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="eu-card-footer">
                    <a href="{{ url('roles') }}" class="btn-eu-secondary">
                        <i class="fas fa-arrow-left fa-xs"></i> Back
                    </a>
                    <button type="submit" class="btn-eu-primary">
                        <i class="fas fa-check fa-xs"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
