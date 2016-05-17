@extends('master')
@section('navigation')
    @include('partials.front-navigation')
@stop
@section('body')
@include('partials.navbar')
<div class="container">
    @include('partials.flash-messages')
    @yield('content')
</div>
@if(auth()->guest())
    @include('partials.google-analytics')
@endif
@stop