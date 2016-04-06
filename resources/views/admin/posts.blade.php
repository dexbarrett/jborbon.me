@extends('admin.master')
@section('page-title', 'administrar posts')
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
@stop
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Título del post</th>
            <th>Etiquetas</th>
            <th class="text-right">
                <a href="{{ action('PostController@create') }}" class="btn btn-info btn-md"><i class="fa fa-file-text button-icon"></i>nuevo post</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="col-md-5">
                    <a href="{{ action('PostController@findBySlug', ['slug' => $post->slug]) }}" target="_blank">{{ $post->title }}</a>
                </td>
                <td class="col-md-5">
                    {!! formatTagsAsLabels($post->tags->toArray()) !!}
                </td>
                <td class="col-md-2 text-right">
                    <div class="btn-group">
                        <a href="{{ action('PostController@edit', ['id' => $post->id]) }}" class="btn btn-primary btn-xs tooltipster" title="editar <strong>{{ $post->title }}</strong>"><i class="fa fa-pencil-square-o button-icon"></i>editar</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="text-center">
    {!! $posts->render() !!}
</div>
@stop
@section('custom-scripts')
<script src="/lib/tooltipster/jquery.tooltipster.min.js"></script>
<script>
    $('.tooltipster').tooltipster({
        theme: 'tooltipster-noir',
        contentAsHTML: true
    });
</script>
@stop