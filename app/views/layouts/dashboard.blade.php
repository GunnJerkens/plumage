@extends('master')

@section('title')
<title>Dashboard | Plumage</title>
@stop

@section('body')
  <section id="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Projects</h1>
          <?php var_dump($projects); ?>
        </div>
      </div>
  </section>
@stop