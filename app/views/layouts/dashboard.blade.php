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
          @foreach($projects as $project)
            <h6><a href="{{ '/project/'.$project->id }}">{{ $project->name }}</a></h6>
          @endforeach
        </div>
      </div>
  </section>
@stop