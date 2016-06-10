<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        </div>
    </div>
</div>