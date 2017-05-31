@extends('admin.master')
@section('page-title', 'editar post')
@section('custom-styles')
<link href="/lib/selectize/selectize.css" rel="stylesheet">
<link href="/lib/selectize/selectize.default.css" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        <div class="col-md-11">
            @include('partials.validation-errors')
        </div>
        {!! Form::open(['url' => action('PostController@update', ['post' => $post->id]), 'method' => 'put']) !!}
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'título del post', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('content', $post->markdown_content, ['class' => 'form-control inline-attachment', 'rows' => '20']) !!}
                </div>
                <div class="checkbox">
                    <label>{!! Form::checkbox('enable_comments', 1, $post->hasCommentsEnabled()) !!} habilitar comentarios en publicación</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::select('tags[]',
                             $postTags, $selectedTags,
                            ['placeholder' => 'seleccionar etiquetas', 'multiple', 'class' => 'selectize']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('category',
                             $postCategories, $post->post_category_id,
                            ['placeholder' => 'seleccionar categoría', 'class' => 'selectize']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('status',
                             $postStatuses, $post->post_status_id,
                            ['placeholder' => 'seleccionar estado', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="panel-footer">
                        {!! Form::submit('Actualizar', ['id' => 'publish', 'class' => 'btn btn-block btn-success']) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@stop
@section('custom-scripts')
<script src="/lib/selectize/selectize.min.js"></script>
<script src="/lib/inline-attachment/inline-attachment.min.js"></script>
<script src="/lib/inline-attachment/jquery.inline-attachment.min.js"></script>
<script src="/lib/inline-attachments.js"></script>
<script>
var inlineAttachmentUrl = '{{ action("PostController@attachImage") }}';
enableInlineAttachments(inlineAttachmentUrl, 'imageUrl', 'picture');

    $('.selectize').selectize({
        highlight: false,
        create: true,
        plugins: ['remove_button'],
        render: {
            option_create: function(data, escape){
                return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        }
    });
    $('#publish').on('click', function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        $('form').first().submit();
    });
</script>
@stop