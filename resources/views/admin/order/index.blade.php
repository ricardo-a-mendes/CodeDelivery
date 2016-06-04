@extends('base')
@section('content')
    <div class="content">
        <div class="row">
            <h1>Orders</h1>
            <a href="{{route('orderAdd')}}" class="btn btn-default">New User</a>
            <br>
            <br>
            <table class="table">
                <tr>
                    <th>Order ID</th>
                    <th>Client</th>
                    <th>Delivery Man</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach($orderCollection as $order)
                    <tr>
                        <td><a href="{{route('orderEdit', ['id' => $order->id])}}">{{$order->id}}</a></td>
                        <td><a href="{{route('clientEdit', ['id' => $order->client->id])}}">{{$order->client->user->name}}</a></td>
                        <td>{{$order->deliveryman->name}}</td>
                        <td>{{$order->total}}</td>
                        <td>{{$orderStatus[$order->status]}}</td>
                        <td>
                            <a href="{{route('orderEdit', ['id' => $order->id])}}">Edit</a> |
                            <a href="{{route('orderDelete', ['id' => $order->id])}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection