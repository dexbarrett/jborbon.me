@extends('admin.master')
@section('page-title', 'administrar posts')
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
<link href='/lib/alertify/alertify.core.css' rel='stylesheet' type='text/css'>
<link href='/lib/alertify/alertify.default.css' rel='stylesheet' type='text/css'>
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
                <i class="fa fa-file-text button-icon"></i>crear {{ $postType->desc }}
            </a>
        </div>
    </div>
</div>
<div class="row">
    {!!Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'posts-list']) !!}
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
                            <a href="{{ action('PostController@edit', ['id' => $post->id]) }}" class="btn btn-primary btn-xs tooltipster" title="editar <strong>{{ $post->title }}</strong>"><i class="fa fa-pencil-square-o button-icon"></i>editar
                            </a>
                            <a href="{{ action('PostController@destroy', ['post' => $post->id]) }}" class="btn btn-danger btn-xs tooltipster delete-post" title="eliminar <strong>{{ $post->title }}</strong>"><i class="fa fa-trash button-icon"></i>eliminar
                            </a>
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
<script src="/lib/alertify/alertify.min.js"></script>
<script>
    $('.tooltipster').tooltipster({
        theme: 'tooltipster-noir',
        contentAsHTML: true
    });

    alertify.set({
        labels: {
            ok: 'Sí',
            cancel: 'No'
        },
        buttonFocus: 'cancel'
    });

    $('table.post-list').on('click', 'a.delete-post', function(e){
        e.preventDefault();
        deleteButton = $(this);
        alertify.confirm("¿Realmente deseas eliminar este elemento?<br/> Esta acción no se puede deshacer", function(isOk){
            if (! isOk) {
                return;
            }

            $('#posts-list').attr('action', deleteButton.attr('href'))
                .submit();

        });
    });
</script>
@stop