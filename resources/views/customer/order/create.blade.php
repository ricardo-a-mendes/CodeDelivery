@extends('layouts.app')

@section('content')
    <div class="container">

        @include('form_error')

        <div class="row">
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>Oh snap :(</strong> {{ Session::get('error') }}
                </div>
            @endif


            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row page-header">
                            <h3>Select Products</h3>
                        </div>
                    </div>
                </div>
                <div class="row">

                    {!! Form::open(['route' => ['customer.order.item.search'], 'method' => 'POST']) !!}
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
                    {!! Form::open(['route' => ['customer.order.items.add'], 'method' => 'POST']) !!}
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
                                <td>{!! Form::checkbox('items[]', $searchedItem->id) !!}</td>
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
                @elseif($isSearch === true)
                    <div class="row">
                        <h5>Ohhh Snap! We didn't find anything. =(</h5>
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
                    {!! Form::open(['route' => 'customer.order.items.store', 'method' => 'POST']) !!}
                    {!! Form::hidden('order_id', $order->id) !!}
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
                            <tfoot>
                            <tr>
                                <td colspan="3" align="right"><strong>Total</strong></td>
                                <td>{{FormatHelper::moneyBR($order->total)}}</td>
                                <td>&nbsp</td>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($orderItems as $i => $item)
                                <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>
                                        <div class="form-group col-md-5">
                                        {!! Form::hidden('orderItem['.$i.'][product_id]', $item->id) !!}
                                        {!! Form::hidden('orderItem['.$i.'][quantity_hidden]', $item->quantity) !!}
                                        {!! Form::number('orderItem['.$i.'][quantity]', $item->quantity, ['step' => '1', 'min' => 1, 'class' => 'form-control input-sm', 'placeholder' => 'Value']) !!}
                                        </div>
                                    </td>
                                    <td>{{FormatHelper::moneyBR($item->product->price)}}</td>
                                    <td>{{FormatHelper::moneyBR($item->quantity*$item->product->price)}}</td>
                                    <td><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="modal" data-target="#deleteConfirmationModal" data-whatever="{{route('customer.order.item.remove', ['id' => $item->id])}}|{{ $item->product->name }}"></span></a>&nbsp;</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! Form::submit('Checkout2', ['name' => 'checkout', 'class' => 'btn btn-success']) !!}
                        @if(count($orderItems) > 0)
                            {!! Form::submit('Update Order', ['name' => 'update', 'class' => 'btn btn-primary']) !!}
                            {!! Form::submit('Checkout', ['name' => 'checkout', 'class' => 'btn btn-success']) !!}
                        @endif
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Deleting Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Removing Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Item to be removed: <strong><span id="itemNameDestination"></span></strong></p>
                    <p>Are you sure ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-danger" href="#">Delete</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(function() {
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var params = button.data('whatever').split("|"); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-footer a').attr('href', params[0]);
                modal.find('.modal-body span#itemNameDestination').text(params[1]);
            })
        });
    </script>
@endsection