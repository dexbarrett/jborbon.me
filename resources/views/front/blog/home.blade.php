@extends('front.master')
@section('page-title', 'Home Page')
@section('content')
<div class="row">
    <div class="col-md-8">
        <ul class="list-unstyled home-page">
            @foreach($posts as $post)
                <li class="blog-post-item">
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
        <div class="row text-center">
            {!! $posts->render() !!}
        </div>
    </div>
    <div class="col-md-3 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading text-center">categorías</div>
                <ul class="list-group">
                    @foreach($categoriesByPostCount as $category)
                        <li class="list-group-item category-list-item">
                            <a href="{{ action('PostController@findByCategory', ['postType' => 'post', 'categorySlug' => $category->slug]) }}">
                                {{ $category->name }} ({{ $category->post_count }})
                            </a>
                        </li>
                    @endforeach
                </ul>
        </div>
    </div>
</div>
@stop