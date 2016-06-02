@extends('base')
@section('content')
    <div class="content">
        <div class="row">
            <h1>Categories</h1>
            <a href="{{route('clientAdd')}}" class="btn btn-default">New Client</a>
            <br>
            <br>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                @foreach($clients as $client)
                    <tr>
                        <td><a href="{{route('clientEdit', ['id' => $client->id])}}">{{$client->id}}</a></td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->address}}</td>
                        <td>
                            <a href="{{route('clientEdit', ['id' => $client->id])}}">Edit</a> |
                            <a href="{{route('clientDelete', ['id' => $client->id])}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection