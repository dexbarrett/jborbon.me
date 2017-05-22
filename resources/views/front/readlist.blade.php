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
@section('custom-scripts')
<script src="/lib/raty/jquery.raty-fa.js"></script>
<script>
$('.rating').raty({
  readOnly: true,
  hints: ['pésimo', 'malo', 'regular', 'bueno', 'osom'],
  score: function() {
    return $(this).data('score');
  }
});
</script>
@stop