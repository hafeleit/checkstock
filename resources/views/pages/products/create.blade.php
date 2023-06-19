@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                  @if(session()->has('message'))
                    <div class="card-body p-3">
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
                    </div>
                  @endif
                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Select file</p>
                            <div class="row">
                                <div class="col-md-6">
                                  <div class="custom-file">
                                    <input type="file" name="file" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
