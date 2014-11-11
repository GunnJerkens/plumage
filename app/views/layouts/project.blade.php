@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="project">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <form role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <input type="text" name="table_name" class="form-control" placeholder="name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }} required>
            </div>
            <button type="submit" class="btn btn-default">Add Type</button>
          </form>
        </div>
      </div>
      @foreach($project_types as $type)
        <div class="row">
          <div class="col-sm-12">
            <h2><a href="{{ '/project/'.$type->project_id.'/'.$type->type }}">{{ $type->type }}</a></h2>
            <a href="{{ '/api/'.$project->name.'/'.$type->type }}" class="btn btn-success" target="_blank">API</a>
            <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/edit' }}" class="btn btn-default">Edit</a>
            <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/delete'}}" class="btn btn-danger">Delete</a>
          </div>
        </div>
      @endforeach
    </div>
  </section>
@stop