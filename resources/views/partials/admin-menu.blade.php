<ul class="nav navbar-nav navbar-right">
    @if(auth()->check())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user button-icon"></span>{{ auth()->user()->username }}  <i class="fa fa-chevron-circle-down"></i></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ action('AdminController@index') }}"><i class="fa fa-book button-icon"></i>Dashboard</a>
            </li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ action('SessionController@destroy') }}">Cerrar Sesión</a></li>
        </ul>
    </li>
    @endif
</ul>