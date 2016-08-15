@extends('front.master')
@section('page-title', "{$postTypeName}s con $filterType $filterName")
@section('content')
<div class="row">
    <div class="col-md-12">
        @if(count($posts))
            <h3 class="text-center">Mostrando {{ $postTypeName }}s con la {{ $filterType }} <strong>{{ $filterName }}</strong></h3>
        @endif
        <ul class="list-unstyled">
            @forelse($posts as $post)
                <li class="blog-post-item">
                    <i class="fa fa-code post-title-icon"></i>
                    <a href="{{ action('PostController@findBySlug', ['slug' => $post->slug]) }}">
                        {{ ucfirst($post->title) }}
                    </a>
                    <span class="label label-danger post-title-date">
                        <i class="fa fa-calendar post-title-date-icon"></i>
                        {{ $post->published_at->format('d/m/Y') }}
                    </span>
                </li>
            @empty
            <h3 class="text-center">No hay posts con la {{ $filterType }} <strong>{{ $filterName}}</strong></h3>
            @endforelse
        </ul>
    </div>
</div>
<div class="row text-center">
    {!! $posts->render() !!}
</div>
@stop