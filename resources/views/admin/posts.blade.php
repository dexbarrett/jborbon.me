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
            <div class="panel-title text-center">listado de {{ $postType->desc }}s - status: <i>{{ $postStatusDesc }}</i></div>
        </div>
        <div class="panel-body">
            <div class="btn-group" role="group" aria-label="...">
                <a href="{{ action('AdminController@index', ['postType' => $postType->name, 'postStatus' => $postStatusPublished->name]) }}" class="btn btn-primary">Publicados <span class="badge">{{ ($postTypePublishedCount > 0) ? $postTypePublishedCount : '' }}</span></a>
                <a href="{{ action('AdminController@index', ['postType' => $postType->name, 'postStatus' => $postStatusDraft->name]) }}" class="btn btn-primary">Borradores <span class="badge">{{ ($postTypeDraftCount > 0) ? $postTypeDraftCount : '' }}</a>
                <a href="{{ action('AdminController@index', ['postType' => $postType->name, 'postStatus' => 'trashed']) }}" class="btn btn-danger"><i class="fa fa-trash fa-lg button-icon"></i> Papelera <span class="badge">{{ ($trashedPostsCount > 0) ? $trashedPostsCount : '' }}</a>
            </div>
            <a href="{{ action('PostController@create', ['postType' => $postType->name]) }}" class="btn btn-info btn-md pull-right">
                <i class="fa fa-file-text button-icon"></i>crear {{ $postType->desc }}
            </a>
        </div>
    </div>
</div>
<div class="row">
    {!!Form::open(['url' => '', 'id' => 'posts-list']) !!}
    <table class="table post-list">
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
                        {!! formatTagsAsLabels($post->tags->toArray(), $post->type->name) !!}
                    </td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            @if($postStatusName != 'trashed')
                                <a href="{{ action('PostController@edit', ['id' => $post->id]) }}" class="btn btn-primary btn-xs tooltipster" title="editar <strong>{{ $post->title }}</strong>"><i class="fa fa-pencil-square-o button-icon"></i>editar
                                </a>
                            @endif
                            @if($postStatusName == 'trashed')
                                <a href="{{ action('PostController@restore', ['id' => $post->id]) }}" class="btn btn-primary btn-xs tooltipster restore-post" title="restaurar <strong>{{ $post->title }}</strong>"><i class="fa fa-undo button-icon"></i>restaurar
                                </a>
                            @endif
                            @if($postStatusName == 'trashed')
                                <a href="{{ action('PostController@destroy', ['postID' => $post->id, 'forceDelete' => 1]) }}" class="btn btn-danger btn-xs tooltipster delete-post" title="eliminar <strong>{{ $post->title }}</strong>"><i class="fa fa-trash button-icon"></i>eliminar
                                </a>
                            @else
                                <a href="{{ action('PostController@destroy', ['postID' => $post->id, 'forceDelete' => 0]) }}" class="btn btn-danger btn-xs tooltipster delete-post" title="enviar <strong>{{ $post->title }}</strong> a la papelera "><i class="fa fa-trash button-icon"></i>papelera
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::close() !!}
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

    $('table.post-list').on('click', 'a.delete-post', function(e){
        e.preventDefault();
        deleteButton = $(this);

        $('#posts-list')
            .attr('action', deleteButton.attr('href'))
            .submit();
    });

    $('table.post-list').on('click', 'a.restore-post', function(e){
        e.preventDefault();

        $('#posts-list')
            .attr('action', $(this).attr('href'))
            .submit(); 
    });
</script>
@stop