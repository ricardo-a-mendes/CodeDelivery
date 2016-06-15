<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('code', 'Code') !!}
            {!! Form::text('code', $cupom->code, ['class' => 'form-control', 'placeholder' => 'Code']) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('value', 'Value') !!}
            {!! Form::number('value', $cupom->value, ['step' => '0.01', 'class' => 'form-control', 'placeholder' => 'Value']) !!}
        </div>
    </div>
</div>