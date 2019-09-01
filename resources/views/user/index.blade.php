@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn btn-primary" href="{{route('users.create')}}" role="button">
            Create new
        </a>
    </div>
    @if(!is_null($Users))
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Telegram Username</th>
                <th scope="col">Active Exam Id</th>
                <th scope="col">Active Question Order</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

                @foreach($Users as $user)
                    <tr>
                        <th scope="row">{{$user->script_name}}</th>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->telegram_username}}</td>
                        <td>{{$user->active_exam_id}}</td>
                        <td>{{$user->active_question_order}}</td>
                        <td><a class="btn btn-primary" href="{{route('users.edit',$user)}}" role="button">
                                Edit
                            </a></td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    @endif

@endsection
