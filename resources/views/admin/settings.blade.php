@extends('admin.master')
@section('page-title', 'Configuración')
@section('content')
<div class="row">
    <div class="col-sm-8 col-md-offset-2">
        @if($imgur->getUserToken())
            <p>Autenticado con imgur</p>
        @else
            <p>No estás autenticado con Imgur. <a href="{{ $imgur->getAuthenticationUrl() }}">Autenticar</a></p>
        @endif
    </div>
</div>
@stop