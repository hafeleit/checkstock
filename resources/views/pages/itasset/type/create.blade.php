@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Asset Type'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .z-1 {
            z-index: 1;
        }

        .form-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #344767;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #344767;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container-fluid py-4">
        <form action="{{ route('asset_types.store') }}" method="post">
            @csrf

            {{-- Header --}}
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 z-1">
                    <h4 class="text-white mb-0">Create Asset Type</h4>
                    <p class="text-white text-sm opacity-8 mb-0">Add a new IT asset category to the system</p>
                </div>
                <div class="col-lg-6 text-end z-1 mt-lg-0 mt-3">
                    <a href="{{ route('asset_types.index') }}" class="btn btn-secondary mb-0 me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary mb-0">Save</button>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger text-white border-0">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><small>{{ $error }}</small></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- Limit width to 8 columns for better readability --}}
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <h5 class="section-title"><i class="fas fa-tag me-2 text-primary"></i>Asset Type Information</h5>

                            <div class="row mt-3">
                                <div class="col-md-12 form-group">
                                    <label>Asset Type Description <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="type_desc" placeholder="e.g. Notebook, Printer, Mobile Phone" value="{{ old('type_desc') }}" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection
