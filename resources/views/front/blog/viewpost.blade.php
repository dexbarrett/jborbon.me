@extends('front.master')

@section('page-title', 'View Post')

@section('custom-styles')
<link href="/lib/prettify/css/prettify.css" rel="stylesheet">
<link href="/lib/prettify/css/peacocks-in-space.css" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <article>
            <h1 class="text-center">{{{ ucfirst($post->title) }}}</h1>
            {!! $post->html_content !!}
        </article> 
    </div>
</div>
@stop

@section('custom-scripts')
<script src="/lib/prettify/js/prettify.js"></script>
<script type="text/javascript">
$(function() {
  $('pre').addClass('prettyprint theme-peacocks-in-space');
  prettyPrint();
});
</script>
@stop