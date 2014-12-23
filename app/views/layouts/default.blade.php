@extends('master')

@section('title')
<title>Plumage</title>
@stop

@section('body')
  <section id="home">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Welcome to plumage</h1>
          <img src="img/feathers.jpg">
        </div>
      </div>
  </section>
@stop