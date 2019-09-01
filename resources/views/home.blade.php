@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">Menu</div>

              <div class="list-group .list-group-flush">
                    <a href="{{Route::get('users')->uri}}" class="list-group-item list-group-item-action">Users</a>
                    <a href="{{Route::get('exams')->uri}}" class="list-group-item list-group-item-action">Exams</a>
                    <a href="{{ Route::get('sends')->uri}}" class="list-group-item list-group-item-action">Send To All Message</a>
                  </div>
          </div>
      </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
