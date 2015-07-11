@extends('front.master')

@section('page-title', 'login user')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title text-center login-box">ingrese su información de usuario</h2>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => 'login']) !!}
                    <fieldset>
                        <div class="form-group">
                            {!! Form::text('username', null, ['class' => 'form-control text-center', 'placeholder' => 'nombre de usuario', 'autocomplete' => 'off']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::password('password', ['class' => 'form-control text-center', 'placeholder' => 'password']) !!}
                        </div>
                        {!! Form::submit('iniciar sesión', ['class' => 'btn btn-danger btn-block']) !!}
                    </fieldset>
                {!! Form::close() !!}
            </div>  
        </div>
    </div>
</div>
@stop