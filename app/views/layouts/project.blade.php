@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="project" class="project">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <h2>{{ $project->name }}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 types">
          @if($project->is_owner)
            <form role="form" method="post" class="addType">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <input type="text" name="table_name" class="form-control" placeholder="type name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }} required>
              </div>
              <button type="submit" class="btn btn-primary">Add Type</button>
            </form>
          @endif
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tbody>
                @foreach($project_types as $type)
                  <tr>
                    <td>
                      <a class="the-type" href="{{ '/project/'.$type->project_id.'/'.$type->type }}">{{ $type->type }}</a>
                      <div class="buttons">
                        <a href="{{ '/api/'.$project->name.'/'.$type->type }}" target="_blank"><i class="fa fa-gear"></i> API</a>
                        @if($project->is_owner)
                          <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/edit' }}"><i class="fa fa-pencil"></i> Edit</a>
                          <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/delete'}}" class="btn-delete"><i class="fa fa-times-circle"></i></a>
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
        <div class="row user-access">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <tbody>
                  @foreach($project->access as $access)
                    <tr>
                      <td><i class="fa fa-user"></i> {{ $access->user_email }}
                        <form role="form" method="post" action="/project/{{$project->id}}/access-remove" class="pull-right">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id" value="{{ $access->user_id }}">
                          <button type="submit" class="btn-delete"><i class="fa fa-times-circle"></i></button>
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
            <form role="form-inline" method="post" action="/project/{{$project->id}}/access" class="add-access text-center">
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