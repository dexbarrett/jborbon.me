@extends('front.master')
@section('page-title', 'Home Page')
@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class="list-unstyled">
            @foreach($posts as $post)
                <li class="blog-post-title">
                    <i class="fa fa-code post-title-icon"></i>
                    <a href="{{ action('PostController@findBySlug', ['slug' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <span class="label label-danger post-title-date">
                        <i class="fa fa-calendar post-title-date-icon"></i>
                        {{ $post->created_at->format('d/m/Y') }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row text-center">
    {!! $posts->render() !!}
</div>
@stop