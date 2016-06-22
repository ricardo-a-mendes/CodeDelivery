@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="row page-header">
                <h1>My Orders <small>Management Area</small></h1>
                <a href="{{route('customerOrderNew')}}" class="btn btn-success">New Order</a>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Code</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderCollection as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->code}}</td>
                        <td>{{FormatHelper::moneyBR($order->value)}}</td>
                        <td>
                            <a href="{{route('customerOrderEdit', ['id' => $order->id])}}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection