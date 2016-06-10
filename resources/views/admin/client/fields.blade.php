<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $client->user->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', $client->user->email, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
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