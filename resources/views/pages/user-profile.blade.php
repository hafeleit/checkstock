@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        * {
            box-sizing: border-box;
        }

        /* ── Shared card shell ── */
        .pf-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            height: 100%;
        }

        /* ── Left: profile summary ── */
        .pf-summary {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 36px 24px 28px;
            text-align: center;
        }

        .pf-avatar-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 3px solid #C8102E;
            padding: 4px;
            margin-bottom: 16px;
            flex-shrink: 0;
        }

        .pf-avatar-ring img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .pf-summary-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .pf-summary-meta {
            font-size: 0.79rem;
            color: #9ca3af;
            line-height: 1.6;
            word-break: break-all;
        }

        .pf-summary-divider {
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #C8102E, #96091F);
            border-radius: 2px;
            margin: 16px auto;
        }

        .pf-summary-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            background: rgba(200, 16, 46, 0.07);
            color: #C8102E;
            font-size: 0.74rem;
            font-weight: 600;
        }

        /* ── Right: edit form ── */
        .pf-form-header {
            padding: 20px 28px 16px;
            border-bottom: 1px solid #f2f2f2;
        }

        .pf-form-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0;
        }

        .pf-form-body {
            padding: 22px 28px 8px;
        }

        .section-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #C8102E;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        .pf-group {
            margin-bottom: 14px;
        }

        .pf-label {
            display: block;
            font-size: 0.74rem;
            font-weight: 500;
            color: #6D6E71;
            margin-bottom: 5px;
        }

        .pf-input {
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

        .pf-input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
        }

        .pf-input[readonly] {
            background: #f8f8f8;
            color: #b0b0b0;
            cursor: default;
        }

        .pf-form-footer {
            padding: 16px 28px 22px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            border-top: 1px solid #f2f2f2;
            margin-top: 8px;
        }

        .btn-pf-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
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

        .btn-pf-secondary:hover {
            background: #f4f5f7;
            border-color: #bbb;
            color: #1a1a1a;
        }

        .btn-pf-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 22px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C8102E 0%, #96091F 100%);
            color: #fff;
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(200, 16, 46, 0.28);
        }

        .btn-pf-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(200, 16, 46, 0.38);
        }

        .btn-pf-primary:active {
            transform: translateY(0);
        }

        .pf-container {
            padding-top: 12rem;
            padding-bottom: 1.5rem;
        }
    </style>

    <div class="container-fluid pf-container">
        <div class="mb-3">
            @include('components.alert')
        </div>

        <div class="row g-4">

            {{-- Left: Profile Summary --}}
            <div class="col-lg-3 col-md-4">
                <div class="pf-card">
                    <div class="pf-summary">
                        <div class="pf-avatar-ring">
                            <img src="/img/avatar.png" alt="avatar">
                        </div>
                        <div class="pf-summary-name">
                            {{ trim((auth()->user()->firstname ?? '') . ' ' . (auth()->user()->lastname ?? '')) ?: '—' }}
                        </div>
                        <div class="pf-summary-meta">{{ auth()->user()->email }}</div>
                        @if (auth()->user()->username)
                            <div class="pf-summary-meta">{{ auth()->user()->username }}</div>
                        @endif

                        <div class="pf-summary-divider"></div>
                    </div>
                </div>
            </div>

            {{-- Right: Edit Form --}}
            <div class="col-lg-9 col-md-8">
                <div class="pf-card">
                    <form role="form" method="POST" action="{{ route('profile.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="pf-form-header">
                            <p class="pf-form-title">Edit Profile</p>
                        </div>

                        <div class="pf-form-body">
                            <div class="section-label">User Information</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="pf-group">
                                        <label class="pf-label">Display Name</label>
                                        <input class="pf-input" type="text" name="username"
                                            value="{{ old('username', auth()->user()->username) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pf-group">
                                        <label class="pf-label">Email</label>
                                        <input class="pf-input" type="email" name="email"
                                            value="{{ old('email', auth()->user()->email) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pf-group">
                                        <label class="pf-label">First Name</label>
                                        <input class="pf-input" type="text" name="firstname"
                                            value="{{ old('firstname', auth()->user()->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pf-group">
                                        <label class="pf-label">Last Name</label>
                                        <input class="pf-input" type="text" name="lastname"
                                            value="{{ old('lastname', auth()->user()->lastname) }}">
                                    </div>
                                </div>
                            </div>

                            @if (auth()->user()->supp_code)
                                <div class="section-label mt-3">Supplier</div>
                                <div class="row g-3">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="pf-group">
                                            <label class="pf-label">Supplier Code</label>
                                            <input class="pf-input" type="text" name="supp_code"
                                                value="{{ old('supp_code', auth()->user()->supp_code) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="pf-form-footer">
                            <a href="{{ route('change-password', ['from' => 'profile']) }}" class="btn-pf-secondary">
                                <i class="fas fa-lock fa-xs"></i> Change Password
                            </a>
                            <button type="submit" class="btn-pf-primary">
                                <i class="fas fa-check fa-xs"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
