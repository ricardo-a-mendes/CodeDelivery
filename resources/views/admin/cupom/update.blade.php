@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row page-header">
            <h1>Cupom Form <small>Update Record</small></h1>
            <a class="btn btn-success" href="{{ route('cupomAdd') }}">New Cupom</a>
            <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteConfirmationModal">Delete this cupom</a>
        </div>
        @include('form_error')
        {!! Form::open(['route' => ['cupomUpdate', $cupom->id], 'method' => 'PUT']) !!}

        @include('admin.cupom.fields')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deleting Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Code Cupom to be deleted: <strong>{{ $cupom->code }}</strong></p>
                    <p>Are you sure ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-danger" href="{{route('cupomDelete', ['id' => $cupom->id])}}">Delete</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
