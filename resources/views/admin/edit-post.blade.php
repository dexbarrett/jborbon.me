@extends('admin.master')
@section('page-title', 'editar post')
@section('custom-styles')
<link href="/lib/selectize/selectize.css" rel="stylesheet">
<link href="/lib/selectize/selectize.default.css" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        @include('partials.validation-errors')
        {!! Form::open(['url' => action('PostController@update', ['post' => $post->id]), 'method' => 'put']) !!}
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'título del post', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('content', $post->markdown_content, ['class' => 'form-control', 'rows' => '20']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::select('tags[]',
                             $postTags, $selectedTags,
                            ['placeholder' => 'seleccionar tags', 'multiple', 'class' => 'selectize']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('category',
                             $postCategories, $post->post_category_id,
                            ['placeholder' => 'seleccionar categoría', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('status',
                             $postStatuses, $post->post_status_id,
                            ['placeholder' => 'seleccionar estado', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-block btn-success">actualizar</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@stop
@section('custom-scripts')
<script src="/lib/selectize/selectize.min.js"></script>
<script>
    $('.selectize').selectize({
        highlight: false,
        plugins: ['remove_button'],
        render: {
            option_create: function(data, escape){
                return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        }
    });
</script>
@stop