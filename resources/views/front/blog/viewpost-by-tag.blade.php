@extends('front.master')
@section('page-title', "posts with tag $tagName")
@section('content')
<div class="row">
    <div class="col-md-12">
        @if(count($posts))
            <h3 class="text-center">Mostrando {{ $postTypeName }}s con la etiqueta <strong>{{ $tagName }}</strong></h3>
        @endif
        <ul class="list-unstyled">
            @forelse($posts as $post)
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
            @empty
            <h3 class="text-center">No hay posts con la etiqueta <strong>{{ $tagName }}</strong></h3>
            @endforelse
        </ul>
    </div>
</div>
<div class="row text-center">
    {!! $posts->render() !!}
</div>
@stop