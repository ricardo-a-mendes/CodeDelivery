@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="row page-header">
                <h1>My Orders <small>Management Area</small></h1>
                <a href="{{route('customer.order.create')}}" class="btn btn-success">New Order</a>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderCollection as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$statusOptions[$order->status]}}</td>
                        <td>{{FormatHelper::moneyBR($order->total)}}</td>
                        <td>
                            @if($order->status == 1)
                            <a href="{{route('customer.order.edit', ['id' => $order->id])}}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection