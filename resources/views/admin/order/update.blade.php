@extends('base')
@section('content')
    <div class="content">
        <div class="row">
            <div class="row page-header">
                <h1>Order Form <small>Update Record</small></h1>
                <a class="btn btn-success" href="{{ route('orderAdd') }}">New Order</a>
            </div>
            @include('form_error')

        </div>

        <div class="row">
            {!! Form::open(['route' => ['orderUpdate', $order->id], 'method' => 'PUT']) !!}
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Client</div>
                    <div class="panel-body"><strong>{{$order->client->user->name}}</strong></div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-3">Delivery Man:</div>
                        <div class="col-md-9">{!! Form::select('user_deleveryman_id', $deliveryMen, isset($order->deliveryman->id) ? $order->deliveryman->id : 0, ['class' => 'form-control']) !!}</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-3">Status:</div>
                        <div class="col-md-9">{!! Form::select('status', $orderStatus, $order->status, ['class' => 'form-control']) !!}</div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
            <div class="col-md-8">
                <h2>Order Items <a href="{{route('orderAdd')}}" class="btn btn-success btn-sm" role="button">Add New Item</a></h2>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right"><strong>Total</strong></td>
                        <td colspan="2">{{$order->total}}</td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{$item->product->id}}</td>
                            <td>{{$item->product->name}}</td>
                            <td>{{$item->product->price}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                            <td>
                                <a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="modal" data-target="#deleteConfirmationModal" data-whatever="{{ $item->product->name }}"></span></a>&nbsp;
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Deleting Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deleting Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Item to be removed: <strong><span id="itemNameDestination"></span></strong></p>
                    <p>Are you sure ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-danger" href="{{route('userDelete', ['id' => ''])}}">Remove</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(function() {
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var item = button.data('whatever'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body span#itemNameDestination').text(item)
            })
        });
    </script>
@endsection