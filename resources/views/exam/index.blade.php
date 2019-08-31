@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-4">
              <div class="card">
                  <div class="card-header">Menu</div>

                  <div class="list-group .list-group-flush">
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
              <a class="btn btn-primary" href="{{route('exams.create')}}" role="button">
                  Create new
              </a>
          </div>
          @if(!is_null($exams))
              <table class="table">
                  <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">نام آزمون</th>
                      <th scope="col">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($exams as $exam)
                          <tr>
                              <th scope="row">{{$exam->id}}</th>
                              <td>{{$exam->name}}</td>
                              <td><a class="btn btn-primary" href="{{route('exams.edit',$exam)}}" role="button">
                                      Edit
                                  </a></td>
                              <td><a class="btn btn-primary" href="{{route('questions.index',$exam)}}" role="button">
                                      View Questions
                                  </a></td>
                          </tr>
                      @endforeach

                  </tbody>
              </table>

          @endif


        </div>
      </div>
        </div>
    </div>

@endsection
