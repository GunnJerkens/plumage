@extends('master')

@section('title')
<title>Plumage</title>
@stop

@section('body')
  <section id="home" class="home">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          @if(Sentry::check())
            <h1>Welcome to plumage</h1>
          @else
            <div class="logo text-center">
              <a href="/"><img src="/img/logo.png" alt="Plumage"></a>
            </div>
            <form class="loginForm" role="form" method="post">
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
  </section>
@stop