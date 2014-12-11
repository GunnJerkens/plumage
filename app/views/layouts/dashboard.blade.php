@extends('master')

@section('title')
<title>Dashboard | Plumage</title>
@stop

@section('body')
  <section id="dashboard">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Projects</h1>
          @foreach($projects as $project)
            <h2><a href="{{ '/project/'.$project->id }}">{{ $project->name }}</a></h2>
          @endforeach
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <h1>Add Project</h1>
          <form role="form" method="post">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <label for="project_name">Project Name</label>
            <input type="text" id="project_name" name="project_name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }}>
            <button type="submit" class="btn btn-default">Create Project</button>
          </form>
        </div>
      </div>
  </section>
@stop