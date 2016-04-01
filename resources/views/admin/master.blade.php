@extends('master')
@section('body')
@include('partials.navbar')
<div class="container">
    @include('partials.flash-messages')
    @yield('content')
</div>
@stop