@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="project" class="project">
    @include('partials.message')
    <div class="container">
      <h1>Types</h1>
      <div class="row">
        <div class="col-sm-6">
          @if($project->is_owner)
            <form role="form" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <input type="text" name="table_name" class="form-control" placeholder="name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }} required>
              </div>
              <button type="submit" class="btn btn-default pull-right">Add Type</button>
            </form>
          @endif
        </div>
        <div class="col-sm-6 types">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tbody>
                @foreach($project_types as $type)
                  <tr>
                    <td>
                      <a class="the-type" href="{{ '/project/'.$type->project_id.'/'.$type->type }}">{{ $type->type }}</a>
                      <div class="buttons pull-right">
                        <a href="{{ '/api/'.$project->name.'/'.$type->type }}" class="btn btn-success" target="_blank">API</a>
                        @if($project->is_owner)
                          <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/edit' }}" class="btn btn-default">Edit</a>
                          <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/delete'}}" class="btn btn-danger">Delete</a>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @if($users)
        <h1>User Access</h1>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <tbody>
                  @foreach($project->access as $access)
                    <tr>
                      <td>{{ $access->user_email }}</td>
                      <td>
                        <form role="form" method="post" action="/project/{{$project->id}}/access-remove">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id" value="{{ $access->user_id }}">
                          <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form role="form-inline" method="post" action="/project/{{$project->id}}/access" class="pull-right">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="id">Add User</label>
                <select id="id" name="id">
                  @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
          </div>
        </div>
      @endif
      </div>
    </div>
  </section>
@stop