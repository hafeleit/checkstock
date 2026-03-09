@extends('layouts.app-dashboard')
@section('content')
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}"></style>

    <div id="dashboard-container">
        <div id="dashboard-1" class="dashboard-view">
            @include('pages.after-sales.dashboard-1')
        </div>
        <div id="dashboard-2" class="dashboard-view">
            @include('pages.after-sales.dashboard-2')
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
@endsection
