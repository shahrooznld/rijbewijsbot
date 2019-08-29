@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn btn-primary" href="{{route('sends.create')}}" role="button">
            Create new
        </a>
    </div>

@endsection
