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
          <form role="form" method="post" class="addForm">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <label for="project_name" class="sr-only">Add Project</label>
            <input type="text" id="project_name" class="form-control" placeholder="Add project" name="project_name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }}>
            <button type="submit" class="btn btn-primary">Create Project</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tbody>
                @foreach($projects as $project)
                  <tr>
                    <td>
                      <a href="{{ '/project/'.$project->id }}" title="{{ $project->name }}">{{ $project->name }}</a>
                      @if($project->is_owner)
                      <span><form role="form" action="{{ '/project/'.$project->id.'/delete' }}" method="post"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="btn btn-danger">&times;</button></form></span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </section>
@stop