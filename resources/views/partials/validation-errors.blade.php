@if($errors->count() > 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <strong>Han ocurrido los siguientes errores:</strong>
        <ul class="fa-ul">
            @foreach($errors->all('<li class="error"><i class="fa fa-li fa-exclamation-circle"></i>:message</li>') as $error)
                {!! $error !!}
            @endforeach
        </ul>
    </div>
@endif