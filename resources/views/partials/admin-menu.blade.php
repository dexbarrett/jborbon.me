<ul class="nav navbar-nav navbar-right">
    @if(auth()->check())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user button-icon"></span>{{ auth()->user()->username }}  <i class="fa fa-chevron-circle-down"></i></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ action('AdminController@index', ['postType' => 'post']) }}"><i class="fa fa-pencil-square-o button-icon"></i>Posts</a>
            </li>
            <li>
                <a href="{{ action('AdminController@index', ['postType' => 'page']) }}"><i class="fa fa-file-text button-icon"></i>Páginas</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ action('AdminController@editProfile') }}"><i class="fa fa-user button-icon" aria-hidden="true"></i></i>Perfil</a>
            </li>
            <li>
                <a href="{{ action('AdminController@showSettings') }}"><i class="fa fa-sliders button-icon" aria-hidden="true"></i></i>Configuración</a>
            </li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ action('SessionController@destroy') }}">Cerrar Sesión <i class="fa fa-sign-out"></i></a></li>
        </ul>
    </li>
    @endif
</ul>