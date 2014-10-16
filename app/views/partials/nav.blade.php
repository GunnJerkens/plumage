<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i>
      </button>
      <a class="navbar-brand" href="/">plumage</a>
    </div>

    <div class="collapse navbar-collapse" id="navbar">
      @if(Sentry::check())
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ Route('dashboard') }}">Dashboard</a></li>
          <li><a href="{{ Route('mapper') }}">Mapper</a></li>
          <li><a href="{{ Route('logout') }}">Logout</a></li>
        </ul>
      @else
        <form class="navbar-form navbar-right" role="form" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
      @endif
    </div>
  </div>
</nav>