@if ($errors)
    <div class="row">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-warning"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> {{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif