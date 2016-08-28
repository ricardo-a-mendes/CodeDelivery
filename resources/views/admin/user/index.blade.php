@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="row page-header">
                <h1>Users <small>Management Area</small></h1>
                <a href="{{route('admin.user.create')}}" class="btn btn-success">New User</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </thead>
                @foreach($userCollection as $user)
                    <tr>
                        <td><a href="{{route('admin.user.edit', ['id' => $user->id])}}">{{$user->id}}</a></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$roles[$user->role]}}</td>
                        <td>
                            <a href="{{route('admin.user.edit', ['id' => $user->id])}}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;
                            <a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="modal" data-target="#deleteConfirmationModal" data-whatever="{{route('admin.user.delete', ['id' => $user->id])}}|{{ $user->name }}"></span></a>&nbsp;
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {!! $userCollection->render() !!}
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
                    <p>User to be deleted: <strong><span id="itemNameDestination"></span></strong></p>
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
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var params = button.data('whatever').split("|"); // Extract info from data-* attributes
                var modal = $(this);
                var form = modal.find('form');
                var newAction = params[0];
                modal.find('.modal-body span#itemNameDestination').text(params[1]);
                form.attr('action', newAction);
            });

            $('button[type="submit"]').on('click', function() {
                $(this).prop('disabled', true);
                $(this).parent().parent().submit();
            });
        });
    </script>
@endsection