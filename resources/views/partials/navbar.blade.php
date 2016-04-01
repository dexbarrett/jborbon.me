    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/" class="navbar-brand site-header">{{ config('site.title') }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          @yield('navigation')
        </div><!--/.nav-collapse -->
      </div>
    </nav>