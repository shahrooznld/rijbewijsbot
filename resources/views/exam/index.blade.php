@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn btn-primary" href="{{route('questions.create')}}" role="button">
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
                    </tr>
                @endforeach

            </tbody>
        </table>

    @endif

@endsection
