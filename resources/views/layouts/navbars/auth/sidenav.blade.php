<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#" style="text-align: center;">
      <img src="{{ URL::to('/') }}/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"> <?php /*
				<span class="ms-1 font-weight-bold">Argon Dashboard 2 Laravel</span>*/ ?> </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height: unset !important;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 {{ Route::currentRouteName() == 'profile' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      @can('dashboard view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 {{ Route::currentRouteName() == 'home' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      @endcan

      @can('usermanagement view')
      <li class="nav-item ">
        <a class="nav-link {{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'active' : '' }}" data-bs-toggle="collapse"
            aria-expanded="{{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'true' : 'false' }}" href="#usermanagment">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 {{  in_array(Request::segment(1), ['users','permissions','roles']) ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">User Management</span>
        </a>
        <div class="collapse {{ in_array(Request::segment(1), ['users','permissions','roles']) ? 'show' : '' }}" id="usermanagment" style="">
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
      @can('itasset view')
      <li class="nav-item ">
        <a class="nav-link {{ Request::segment(1) == 'itasset' ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ Request::segment(1) == 'itasset' ? 'true' : 'false' }}" href="#productsExample">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-laptop {{ Request::segment(1) == 'itasset' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">IT Asset</span>
        </a>
        <div class="collapse {{ Request::segment(1) == 'itasset' ? 'show' : '' }}" id="productsExample" style="">
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

      @can('checkstockrsa view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'checkstock.index' ? 'active' : '' }}" href="{{ route('checkstock.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-archive-2 {{ Request::segment(1) == 'checkstock' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Check Stock RSA</span>
        </a>
      </li>
      @endcan

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

      @can('salesusi view')
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'sales-usi.index' ? 'active' : '' }}" href="{{ route('sales-usi.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-archive-2 {{ Request::segment(1) == 'sales-usi' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Sales USI</span>
        </a>
      </li>
      @endcan

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

      @can('invrecord view')
      <!--<li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'inv-record.index' ? 'active' : '' }}" href="{{ route('inv-record.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-money-coins {{ Request::segment(1) == 'inv-record' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">INV Record</span>
        </a>
      </li>-->
      @endcan

      @can('Commissions List')
      <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link" id="commissions-link">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-money-coins {{ Request::segment(1) == 'commissions' ? 'text-primary' : 'text-dark' }} text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Commissions</span>
          </a>
      </li>
      @endcan

      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
      document.getElementById('commissions-link').addEventListener('click', function() {
          Swal.fire({
              title: 'Confirm Password',
              input: 'password',
              inputLabel: 'Password',
              inputPlaceholder: 'Enter your password',
              inputAttributes: {
                  autocapitalize: 'off',
                  autocorrect: 'off',
                  autocomplete: 'off',  // ปิด auto complete
              },
              showCancelButton: true,
              confirmButtonText: 'Confirm',
              showLoaderOnConfirm: true,
              preConfirm: (password) => {
                  return fetch('{{ route("commission.verify-password") }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({ password: password })
                  })
                  .then(async response => {
                      const data = await response.json();
                      if (!response.ok) {
                          // แสดงข้อความ error จาก backend
                          throw new Error(data.error || 'เกิดข้อผิดพลาด');
                      }
                      return data;
                  })
                  .catch(error => {
                      Swal.showValidationMessage(error.message);
                  });
              },
              allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
              if (result.isConfirmed && result.value.success) {
                  window.location.href = '{{ route("commissions.index") }}';
              } else if(result.isConfirmed) {
                  Swal.fire('Error', 'Incorrect password', 'error');
              }
          })
      });
      </script>

</aside>
