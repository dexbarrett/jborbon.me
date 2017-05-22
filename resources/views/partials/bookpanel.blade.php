<div class="panel panel-default">
  <div class="panel-heading">
  </div>
  <div class="panel-body book-review">
    <div class="row">
        <div class="col-xs-12 col-md-2">
            <div class="row">
                <div class="col-xs-12 col-xs-offset-4 col-md-offset-0">
                    <a href="{{ $book['url'] }}">
                        <img src="{{ $book['imageUrl'] }}" alt="{{ $book['title'] }}" class="img-responsive">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-10">
            <a href="{{ $book['url'] }}">
                <h4>{{ $book['title'] }}</h4>
            </a>
            <ul>
                <li>Autor - {{ $book['author'] }}</li>
                <li>Formato <span>{!! getBookFormatIcon($book['format']) !!}</span></li>
                @if($book['startedAt'])
                    <li>Iniciado el {{ $book['startedAt'] }}</li>
                @endif
                <li>Finalizado el {{ $book['finishedAt'] }}</li>
                <li>Mi calificación: <span class="rating">
                    {!! getBookReviewIcons($book['rating']) !!}
                </span>
                </li>
            </ul>
            @if(strlen($book['review']))
                <hr>
                <p><strong>Mi reseña:</strong> {{ lcfirst($book['review']) }}</p>
            @endif
        </div>
    </div>
  </div>
</div>