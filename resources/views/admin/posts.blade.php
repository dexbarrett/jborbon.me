@extends('admin.master')
@section('page-title', 'administrar posts')
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
@stop
@section('content')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title text-center">listado de {{ $postType->desc }}s - status: <i>{{ $postStatus->desc }}</i></div>
        </div>
        <div class="panel-body">
            <div class="btn-group" role="group" aria-label="...">
                <a href="{{ action('AdminController@index', ['postType' => $postType->name, 'postStatus' => $postStatusPublished->name]) }}" class="btn btn-primary">Publicados <span class="badge">{{ $postTypePublishedCount }}</span></a>
                <a href="{{ action('AdminController@index', ['postType' => $postType->name, 'postStatus' => $postStatusDraft->name]) }}" class="btn btn-warning">Borradores <span class="badge">{{ $postTypeDraftCount }}</a>
            </div>
            <a href="{{ action('PostController@create', ['postType' => $postType->name]) }}" class="btn btn-info btn-md pull-right">
                <i class="fa fa-file-text button-icon"></i>crear {{ $postType->desc }}</a>
        </div>
    </div>
</div>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Etiquetas</th>
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
</div>
<div class="row">
    <div class="text-center">
        {!! $posts->render() !!}
    </div>
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