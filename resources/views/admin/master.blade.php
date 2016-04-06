@extends('master')
@section('navigation')
    @include('partials.admin-menu')
@stop
@section('body')
@include('partials.navbar')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            @include('partials.flash-messages')
        </div>
    </div>
    @yield('content')
</div>
@stop