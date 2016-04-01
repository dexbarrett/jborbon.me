<?php
namespace DexBarrett\Services\Validation;

class PostValidator extends FormValidator
{
    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'tags' => 'required|array',
        'category' => 'required|integer|exists:post_categories,id',
        'status' => 'required|integer|exists:post_statuses,id'
    ];

    protected $friendlyNames = [
        'title' => 'título',
        'content' => 'contenido',
        'tags' => 'etiquetas',
        'category' => 'categoría',
        'status' => 'estado'
    ];
}