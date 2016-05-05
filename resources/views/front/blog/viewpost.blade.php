@extends('front.master')

@section('page-title', 'View Post')

@section('custom-styles')
<link href="/lib/prettify/css/prettify.css" rel="stylesheet">
<link href="/lib/prettify/css/peacocks-in-space.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-punk.css" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center">{{{ ucfirst($post->title) }}}</h1>
        <article class="post-content">
            {!! $post->html_content !!}
        
        <hr>
        {!! formatTagsAsLabels($post->tags->toArray(), $post->type->name) !!} 
        </article>
    </div>
</div>
@stop

@section('custom-scripts')
<script src="/lib/prettify/js/prettify.js"></script>
<script src="/lib/tooltipster/jquery.tooltipster.min.js"></script>
<script type="text/javascript">
$(function() {
  $('pre').addClass('prettyprint theme-peacocks-in-space');
  prettyPrint();
});

$('.post-tooltip').tooltipster({
    theme: 'tooltipster-punk'
});
</script>
@stop