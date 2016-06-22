@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row page-header">
                            <h3>Select Products</h3>
                        </div>
                    </div>
                </div>
                <div class="row">

                    {!! Form::open(['route' => ['customerOrderItemSearch'], 'method' => 'POST']) !!}
                    {!! Form::hidden('order_id', $order->id) !!}
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="input-group">
                                {!! Form::text('product', '', ['class' => 'form-control', 'placeholder' => 'Type a product name to search']) !!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Go!</button>
                                  </span>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
                <div class="row">
                    {!! Form::open(['route' => ['customerOrderAddItems'], 'method' => 'POST']) !!}
                    {!! Form::hidden('order_id', $order->id) !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($foundItems as $searchedItem)
                            <tr>
                                <td>{!! Form::checkbox('item[]', $searchedItem->id) !!}</td>
                                <td>{{$searchedItem->name}}</td>
                                <td>{{$searchedItem->price}}</td>
                                <td>Remove</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        {!! Form::submit('Add selected items to Order', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>

            <div class="col-md-7">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row page-header">
                            <h3>Order Details</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderItems as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->quantity*$item->price}}</td>
                                    <td>Remove</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection