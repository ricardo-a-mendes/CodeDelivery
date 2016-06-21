@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row page-header">
            <h1>Client Form <small>Create Record</small></h1>
            @include('form_error')
        </div>
        {!! Form::open(['route' => ['adminClientCreate'], 'method' => 'POST']) !!}

        @include('admin.client.fields')

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