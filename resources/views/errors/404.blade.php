@extends('front.master')
@section('page-title', 'Página no encontrada')
@section('content')
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <h1 class="text-center notfound-header">Whoops!</h1>
        <h3 class="text-center">la página no existe o no está disponible</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-4">
        <img src="/image/404.jpg" class="img-responsive" width="368" height="357" alt="404">
    </div>
</div>
@stop