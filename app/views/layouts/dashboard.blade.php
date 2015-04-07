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
          <form role="form" method="post" class="form-inline pull-right">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <label for="project_name">Add Project</label>
            <input type="text" id="project_name" class="form-control" name="project_name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }}>
            <button type="submit" class="btn btn-primary">Create Project</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <h1>Projects</h1>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tbody>
                @foreach($projects as $project)
                  <tr>
                    <td><a href="{{ '/project/'.$project->id }}">{{ $project->name }}</a></td>
                    <td><form role="form" action="{{ '/project/'.$project->id.'/delete' }}" method="post"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="btn btn-danger">Delete Project</button></form></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </section>
@stop