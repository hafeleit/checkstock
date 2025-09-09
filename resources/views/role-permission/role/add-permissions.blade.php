@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav', ['title' => 'Online Order'])
<style media="screen">
  input[type="checkbox"]:checked {
    accent-color: #fb6340;
  }

</style>
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

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Role : {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <h4 for="" class="text-secondary">Permissions</h4>
                                <div class="row">
                                    <?php
                                      $title_store = '';
                                     ?>
                                    @foreach ($permissions as $key => $permission)
                                    <?php
                                      $title = explode(' ',$permission->name);
                                      if($title_store != $title[0]){
                                        echo '<hr class="horizontal bg-secondary my-1"><h5 class="text-uppercase">'.$title[0].'</h5>';
                                      }
                                      $title_store = $title[0];
                                     ?>
                                    <div class="col-md-3">
                                        <label>
                                            <input
                                                id="{{$permission->name}}"
                                                class="custom-control-input"
                                                type="checkbox"
                                                name="permission[]"
                                                value="{{ $permission->name }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}
                                            />
                                            <label class="custom-control-label text-sm text-uppercase text-secondary" for="{{$permission->name}}">{{ implode(' ', array_slice($title, 1)) }}</label>

                                        </label>
                                    </div>

                                    @endforeach
                                </div>

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
