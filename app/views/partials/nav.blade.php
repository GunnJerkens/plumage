@if(Sentry::check())

  <nav class="pushy pushy-left">
    <ul>
      <li><a href="{{ Route('dashboard') }}"><i class="fa fa-clone"></i> Dashboard</a></li>
      <li><a href="{{ Route('account') }}"><i class="fa fa-user"></i> Account</a></li>
      @if(Sentry::getUser()->hasAccess('manage'))
        <li><a href="{{ Route('manage') }}"><i class="fa fa-gear"></i> Manage</a></li>
      @endif
      <li><a href="{{ Route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>

  <!-- Site Overlay -->
  <div class="site-overlay"></div>

  <div id="container" class="wrapper">

    <!-- Menu Button -->
    <div class="menu-btn">
      <i class="fa fa-bars"></i>
    </div>

    <div class="container">
      <div class="logo text-center">
        <a href="/"><img src="/img/logo.png" alt="Plumage"></a>
      </div>
    </div>

@endif