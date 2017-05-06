@extends('admin.master')
@section('page-title', 'Perfil')
@section('content')
<div class="row">
    <div class="col-sm-8 col-md-offset-2">
        @include('partials.validation-errors')
        <form action="{{ action('AdminController@saveProfile') }}" method="post">
            <div class="form-group">
                <label for="username">Nombre de usuario</label>
                {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
            <label for="password">Nueva contraseña</label>
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
            <label for="password_confirmation">Confirmar nueva contraseña</label>
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group text-right">
                {!! Form::submit('Guardar perfil', ['class' => 'btn btn-success']) !!}
            </div>
        </form>
    </div>
</div>
@stop