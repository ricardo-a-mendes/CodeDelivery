@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="row page-header">
                <h1>User Form <small>Create Record</small></h1>
            </div>
            @include('form_error')
        </div>
        {!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST']) !!}

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
@endsection