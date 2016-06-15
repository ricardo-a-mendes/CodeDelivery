@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row page-header">
            <h1>Cupom Form <small>Create Record</small></h1>
        </div>
        @include('form_error')
        {!! Form::open(['route' => ['cupomCreate'], 'method' => 'POST']) !!}

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
@endsection
