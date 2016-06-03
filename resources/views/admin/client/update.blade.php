@extends('base')
@section('content')
    <div class="content">
        <div class="row">
            <h1>Client Form</h1>
            @if ($errors)
                <ul class="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        {!! Form::open(['route' => ['clientUpdate', $client->id], 'method' => 'PUT']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $client->user->name, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', $client->user->email, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group row">
                    {!! Form::label('password_confirmation', 'Retype Password') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('address', 'Address') !!}
                    {!! Form::textarea('address', $client->address, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::text('city', $client->city, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('state', 'State') !!}
                        {!! Form::text('state', $client->state, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('zipcode', 'Zip') !!}
                        {!! Form::text('zipcode', $client->zipcode, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
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