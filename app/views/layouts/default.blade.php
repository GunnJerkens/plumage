@extends('master')

@section('title')
<title>Plumage</title>
@stop

@section('body')
  <section id="home">
    @if(Session::has('error'))
      <div class="container">
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          {{ Session::get('message') }}
        </div>
      </div>
    @endif
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <h1>Welcome to plumage</h1>
        </div>
      </div>
  </section>
@stop