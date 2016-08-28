@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="row page-header">
                <h1>User Form <small>Update Record</small></h1>
                <a class="btn btn-success" href="{{ route('admin.user.create') }}">New User</a>
                <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteConfirmationModal">Delete this user</a>
            </div>
            @include('form_error')
        </div>

        {!! Form::open(['route' => ['admin.user.update', $user->id], 'method' => 'PUT']) !!}

        @include('admin.user.fields')

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
                    <p>User to be deleted: <strong>{{ $user->name }}</strong></p>
                    <p>Are you sure ?</p>
                </div>
                {!! Form::open(['route' => ['admin.user.delete', $user->id], 'method' => 'DELETE']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(function() {
            $('button[type="submit"]').on('click', function() {
                $(this).prop('disabled', true);
                $(this).parent().parent().submit();
            });
        });
    </script>
@endsection