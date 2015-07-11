@extends('front.master')

@section('page-title', 'View Post')

@section('custom-styles')
{!! Html::style('prettify/css/prettify.css') !!}
{!! Html::style('prettify/css/peacocks-in-space.css') !!}
@stop

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1>PrettyPrint</h1>

<p>This theme is for <a href="https://code.google.com/p/google-code-prettify/">Google Code Prettify</a> which can be used to syntax highlight code within a &ltpre&gt; tag.</p>

<p>To use, simply copy and paste the CSS from the source of this document into your project, and use with an existing code prettify setup. You can either add the 'theme-peacocks-in-space' class each &ltpre&gt; element, or just remove it from the CSS to style all of them.</p>

<p>Enjoy!</p>

<pre><code><span class="pun">&lt;?</span><span class="pln">php

</span><span class="com">// app/controllers/ArticleController.php</span><span class="pln">

</span><span class="kwd">class</span><span class="pln"> </span><span class="typ">ArticleController</span><span class="pln"> </span><span class="kwd">extends</span><span class="pln"> </span><span class="typ">BaseController</span><span class="pln">
</span><span class="pun">{</span><span class="pln">
    </span><span class="kwd">public</span><span class="pln"> </span><span class="kwd">function</span><span class="pln"> showIndex</span><span class="pun">()</span><span class="pln">
    </span><span class="pun">{</span><span class="pln">
        </span><span class="kwd">return</span><span class="pln"> </span><span class="typ">View</span><span class="pun">::</span><span class="pln">make</span><span class="pun">(</span><span class="str">'index'</span><span class="pun">);</span><span class="pln">
    </span><span class="pun">}</span><span class="pln">

    </span><span class="kwd">public</span><span class="pln"> </span><span class="kwd">function</span><span class="pln"> showSingle</span><span class="pun">(</span><span class="pln">$articleId</span><span class="pun">)</span><span class="pln">
    </span><span class="pun">{</span><span class="pln">
        </span><span class="kwd">return</span><span class="pln"> </span><span class="typ">View</span><span class="pun">::</span><span class="pln">make</span><span class="pun">(</span><span class="str">'single'</span><span class="pun">);</span><span class="pln">
    </span><span class="pun">}</span><span class="pln">
</span><span class="pun">}</span></code></pre>    
    </div>
</div>
@stop

@section('custom-scripts')
{!! Html::script('prettify/js/prettify.js') !!}
<script type="text/javascript">
$(function() {
  $('pre').addClass('prettyprint theme-peacocks-in-space');
  prettyPrint();
});
</script>
@stop