<ul class="nav navbar-nav navbar-right">
    <li><a href="{{ url('goodreads-read-list') }}">lecturas recientes</a></li>
    <li><a href="{{ url('acerca-de') }}">Acerca de</a></li>
    <li><a href="{{ action('FeedController@render') }}"><i class="fa fa-rss-square fa-2x"></i></a></li>
</ul>