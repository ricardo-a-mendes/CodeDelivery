@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="row page-header">
                <h1>Orders <small>Management Area</small></h1>
                <!-- <a href="{{route('admin.order.create')}}" class="btn btn-success">New Order</a> -->
            </div>
            <table class="table table-striped">
                <thead>
                    <th>Order ID</th>
                    <th>Client</th>
                    <th>Delivery Man</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                @foreach($orderCollection as $order)
                    <tr>
                        <td><a href="{{route('admin.order.edit', ['id' => $order->id])}}">{{$order->id}}</a></td>
                        <td><a href="{{route('admin.client.edit', ['id' => $order->client->id])}}">{{$order->client->user->name}}</a></td>
                        <td>{{$order->deliveryman->name or ''}}</td>
                        <td>{{FormatHelper::moneyBR($order->total)}}</td>
                        <td>{{$orderStatus[$order->status]}}</td>
                        <td>
                            <a href="{{route('admin.order.edit', ['id' => $order->id])}}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {!! $orderCollection->render() !!}
    </div>
@endsection