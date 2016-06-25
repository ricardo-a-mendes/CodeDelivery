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
                @if(count($foundItems)>0)
                <div class="row">
                    {!! Form::open(['route' => ['customerOrderAddItems'], 'method' => 'POST']) !!}
                    {!! Form::hidden('order_id', $order->id) !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Unity Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($foundItems as $searchedItem)
                            <tr>
                                <td>{!! Form::checkbox('item[]', $searchedItem->id) !!}</td>
                                <td>{{$searchedItem->name}}</td>
                                <td>{{$searchedItem->category->name}}</td>
                                <td>{{FormatHelper::moneyBR($searchedItem->price)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        {!! Form::submit('Add selected items to Order', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                @endif
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
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{FormatHelper::moneyBR($item->product->price)}}</td>
                                    <td>{{FormatHelper::moneyBR($item->quantity*$item->product->price)}}</td>
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