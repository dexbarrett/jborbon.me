@extends('front.master')
@section('page-title', 'lecturas recientes')
@section('content')
<div class="row book-reviews-header">
  <div class="col-xs-12 text-center">
    <h1>lecturas más recientes</h1>
  </div>
</div>
<div class="row">
    <div id="book-reviews" class="col-sm-8 col-sm-offset-2">
        @foreach($readList as $book)
            @include('partials.bookpanel')
        @endforeach
    </div>
</div>
@stop