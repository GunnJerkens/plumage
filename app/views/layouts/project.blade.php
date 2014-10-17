@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="project">
    @if(Session::has('error'))
      <div class="container">
        <div class="alert {{ Session::get('error') ? 'alert-danger' : 'alert-success' }}" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          {{ Session::get('message') }}
        </div>
      </div>
    @endif
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <form role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <input type="text" name="table_name" class="form-control" placeholder="name"{{ Session::has('field_data') ? 'value="'.(Session::get('field_data')).'"' : '' }} required>
            </div>
            <button type="submit" class="btn btn-default">Add Table</button>
          </form>
        </div>
      </div>
      @foreach($project_fields as $fields)
        <div class="row">
          <div class="col-sm-12">
            <h2>{{ $fields->name }}</h2>
            <a href="" class="btn btn-default">Edit</a>
            <a href="{{ '/project/'.$fields->project_id.'/'.$fields->name.'/delete'}}" class="btn btn-danger">Delete</a>
          </div>
        </div>
      @endforeach
  </section>
@stop