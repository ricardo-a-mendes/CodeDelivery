@extends('base')
@section('content')
    <div class="content">
        <div class="row">
            <h1>Users</h1>
            <a href="{{route('userAdd')}}" class="btn btn-default">New User</a>
            <br>
            <br>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                @foreach($userCollection as $user)
                    <tr>
                        <td><a href="{{route('userEdit', ['id' => $user->id])}}">{{$user->id}}</a></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$roles[$user->role]}}</td>
                        <td>
                            <a href="{{route('userEdit', ['id' => $user->id])}}">Edit</a> |
                            <a href="{{route('userDelete', ['id' => $user->id])}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection