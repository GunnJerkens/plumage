@extends('master')

@section('title')
<title>Plumage</title>
@stop

@section('body')
  <div class="wrapper">

    <section id="home" class="home">
      @include('partials.message')
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
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
          </div>
        </div>
    </section>
@stop