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
                <th scope="col">Question Nl</th>
                <th scope="col">Question Fa</th>
                <th scope="col">Correct Answer</th>
                <th scope="col">Is free?</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exams as $exam)
             @php
             $questions = $exam->questions;
             @endphp
                @foreach($questions as $question)
                    <tr>
                        <th scope="row">{{$question->script_name}}</th>
                        <td>{{$exam->name}}</td>
                        <td>{{$question->question_nl}}</td>
                        <td>{{$question->question_fa}}</td>
                        <td>{{$question->correct_answer}}</td>
                        <td>{{$question->is_free ? 'Gratis' : ''}}</td>
                        <td><a class="btn btn-primary" href="{{route('questions.edit',$question)}}" role="button">
                                Edit
                            </a></td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

    @endif

@endsection
