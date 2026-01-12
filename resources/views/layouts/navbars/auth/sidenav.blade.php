<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#">
      <img src="{{ URL::to('/') }}/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"></a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      {{-- Profile --}}
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 {{ Route::currentRouteName() == 'profile' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>

      {{-- User Management --}}
      @can('usermanagement view')
      <li class="nav-item ">
        <a class="nav-link {{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'active' : '' }}" data-bs-toggle="collapse"
          aria-expanded="{{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'true' : 'false' }}" href="#usermanagment">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 {{  in_array(Request::segment(1), ['users','permissions','roles']) ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">User Management</span>
        </a>
        <div class="collapse {{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'show' : '' }}" id="usermanagment">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}" href="{{ url('users') }}">
                <span class="sidenav-mini-icon text-xs"> U </span>
                <span class="sidenav-normal"> Users </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'permissions.index' ? 'active' : '' }}" href="{{ url('permissions') }}">
                <span class="sidenav-mini-icon text-xs"> P </span>
                <span class="sidenav-normal"> Permissions </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}" href="{{ url('roles') }}">
                <span class="sidenav-mini-icon text-xs"> R </span>
                <span class="sidenav-normal"> Role </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      {{-- IT Asset --}}
      @can('itasset view')
      <li class="nav-item ">
        <a class="nav-link {{ Request::segment(1) == 'itasset' ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ Request::segment(1) == 'itasset' ? 'true' : 'false' }}" href="#productsExample">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-laptop {{ Request::segment(1) == 'itasset' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">IT Asset</span>
        </a>
        <div class="collapse {{ Request::segment(1) == 'itasset' ? 'show' : '' }}" id="productsExample">
          <ul class="nav nav-sm flex-column">
            @can('itasset create')
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'itasset.create' ? 'active' : '' }}" href="{{ route('itasset.create') }}">
                <span class="sidenav-mini-icon text-xs"> N </span>
                <span class="sidenav-normal"> New Asset </span>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'itasset.index' ? 'active' : '' }}" href="{{ route('itasset.index') }}">
                <span class="sidenav-mini-icon text-xs"> A </span>
                <span class="sidenav-normal"> Asset List </span>
              </a>
            </li>
            @can('itasset_type create')
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'asset_types.index' ? 'active' : '' }}" href="{{ route('asset_types.index') }}">
                <span class="sidenav-mini-icon text-xs"> T </span>
                <span class="sidenav-normal"> Asset Type Management </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcan

      {{-- HTH Employee --}}
      @can('hthemployee view')
      <li class="nav-item">
        <a class="nav-link {{ str_contains(request()->url(), 'user-management') == true ? 'active' : '' }}" href="{{ route('user-management') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-book-bookmark {{ str_contains(request()->url(), 'user-management') == true ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">HTH Employee</span>
        </a>
      </li>
      @endcan

      {{-- Online Order --}}
      @can('onlineorder view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'onlineorder.index' ? 'active' : '' }}" href="{{ route('onlineorder.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-basket {{ Route::currentRouteName() == 'onlineorder.index' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Online Order</span>
        </a>
      </li>
      @endcan

      {{-- Consumer Label --}}
      @can('consumerlabel view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'product-items' ? 'active' : '' }}" href="{{ route('product-items.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 {{ Request::segment(1) == 'product-items' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Consumer Label</span>
        </a>
      </li>
      @endcan

      {{-- Sales USI --}}
      @can('salesusi view')
      <li class="nav-item">
        <a class="nav-link {{ Request::segment(1) == 'sales-usi' ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ Request::segment(1) == 'sales-usi' ? 'true' : 'false' }}" href="#salesUsiExample">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-archive-2 {{ Request::segment(1) == 'sales-usi' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Sales USI</span>
        </a>
        <div class="collapse {{ Request::segment(1) == 'sales-usi' ? 'show' : '' }}" id="salesUsiExample">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'sales-usi.index' ? 'active' : '' }}" href="{{ route('sales-usi.index') }}">
                <span class="sidenav-mini-icon text-xs"> S </span>
                <span class="sidenav-normal"> Sale USI </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'sales-usi.pc' ? 'active' : '' }}" href="{{ route('sales-usi.pc') }}">
                <span class="sidenav-mini-icon text-xs"> S </span>
                <span class="sidenav-normal"> Sale USI - PC </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'sales-usi.product-info.index' ? 'active' : '' }}" href="{{ route('sales-usi.product-info.index') }}">
                <span class="sidenav-mini-icon text-xs"> P </span>
                <span class="sidenav-normal"> Product Info </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      {{-- SO Status --}}
      @can('sostatus view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'so-status-usi.index' ? 'active' : '' }}" href="{{ route('so-status.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-delivery-fast {{ Request::segment(1) == 'so-status' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">SO Status</span>
        </a>
      </li>
      @endcan

      {{-- Commissions --}}
      @can('Commissions List')
      <li class="nav-item">
        <a href="{{ route('commissions.index') }}" class="nav-link">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-money-coins {{ Request::segment(1) == 'commissions' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Commissions</span>
        </a>
      </li>
      @endcan

      <!-- Delivery Tracking -->
      @can('delivery view')
      <li class="nav-item ">
        <a class="nav-link {{ Request::segment(1) == 'delivery-trackings' ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ Request::segment(1) == 'delivery-trackings' ? 'true' : 'false' }}" href="#invoiceTrackingsExample">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist {{ Request::segment(1) == 'delivery-trackings' ? 'text-primary' : 'text-dark' }} text-sm opacity-10" viewBox="0 0 16 16">
              <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
              <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
            </svg>
          </div>
          <span class="nav-link-text ms-1">Delivery Trackings</span>
        </a>
        <div class="collapse {{ Request::segment(1) == 'delivery-trackings' ? 'show' : '' }}" id="invoiceTrackingsExample">
          <ul class="nav nav-sm flex-column">
            @can('delivery view lists')
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'delivery-trackings.index' ? 'active' : '' }}" href="{{ route('delivery-trackings.index') }}">
                <span class="sidenav-mini-icon text-xs"> L </span>
                <span class="sidenav-normal"> Lists </span>
              </a>
            </li>
            @endcan
            @can('delivery view details')
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'delivery-trackings.details' ? 'active' : '' }}" href="{{ route('delivery-trackings.details') }}">
                <span class="sidenav-mini-icon text-xs"> D </span>
                <span class="sidenav-normal"> Details </span>
              </a>
            </li>
            @endcan
            @can('delivery import file')
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'delivery-trackings.imports.index' ? 'active' : '' }}" href="{{ route('delivery-trackings.imports.index') }}">
                <span class="sidenav-mini-icon text-xs"> I </span>
                <span class="sidenav-normal"> Import </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcan

      {{-- Audit Logs --}}
      @role('super-admin')
      <li class="nav-item ">
        <a class="nav-link {{ Request::segment(1) == 'audit-logs' ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ Request::segment(1) == 'audit-logs' ? 'true' : 'false' }}" href="#auditLogsDropdown">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="{{ Request::segment(1) == 'audit-logs' ? 'text-primary' : 'text-dark' }} text-sm opacity-10">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
          </div>
          <span class="nav-link-text ms-1">Logs</span>
        </a>
        <div class="collapse {{ Request::segment(1) == 'audit-logs' ? 'show' : '' }}" id="auditLogsDropdown">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'audit-logs.details' ? 'active' : '' }}" href="{{ route('audit-logs.details') }}">
                <span class="sidenav-mini-icon text-xs"> L </span>
                <span class="sidenav-normal">  Log Details </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName() == 'audit-logs.errors' ? 'active' : '' }}" href="{{ route('audit-logs.errors') }}">
                <span class="sidenav-mini-icon text-xs"> E </span>
                <span class="sidenav-normal"> Error Logs </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endrole
</aside>