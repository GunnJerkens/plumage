@if(Sentry::check())

  <!-- Pushy Menu -->
  <nav class="pushy pushy-left">
    <ul>
      <li><a href="{{ Route('dashboard') }}">Dashboard</a></li>
      <li><a href="{{ Route('account') }}">Account</a></li>
      @if(Sentry::getUser()->hasAccess('manage'))
        <li><a href="{{ Route('manage') }}">Manage</a></li>
      @endif
      <li><a href="{{ Route('logout') }}">Logout</a></li>
    </ul>
  </nav>

  <!-- Site Overlay -->
  <div class="site-overlay"></div>

  <!-- IMPORTANT FOR SLIDING CONTENT -->
  <div id="container">

    <!-- Menu Button -->
    <div class="menu-btn">
      <i class="fa fa-bars"></i>
    </div>

    <div class="logo text-center">
      <a href="/"><img src="/img/logo.png" alt="Plumage"></a>
    </div>

@endif