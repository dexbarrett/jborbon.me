<?php
return [

    'goodreadsParams' => [
        'v' => 2,
        'id' => '7365443',
        'shelf' => 'personal-site',
        'per_page' => 10,
        'sort' => 'date_read',
        'order' => 'd',
        'key' => getenv('GOODREADS_API_KEY')
    ]

];