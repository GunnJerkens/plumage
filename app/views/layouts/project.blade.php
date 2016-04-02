@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="project" class="project">
    @include('partials.message')
    <div class="container view">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <h2>{{ $project->name }}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 types">
          @if($user->is_admin || $project->is_owner || $access->can_edit)
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
                @foreach($types as $type)
                  <tr>
                    <td>
                      <a class="the-type" href="{{ '/project/'.$type->project_id.'/'.$type->type }}">{{ $type->type }}</a>
                      <div class="buttons">
                        <a href="{{ '/api/'.$project->name.'/'.$type->type }}" target="_blank"><i class="fa fa-gear"></i> API</a>
                        @if($user->is_admin || $project->is_owner || $access->can_edit)
                          <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/edit' }}"><i class="fa fa-pencil"></i> Edit</a>
                        @endif
                        @if($user->is_admin || $project->is_owner || $access->can_delete)
                          <a href="#" class="btn-delete" data-toggle="modal" data-target="#deleteModal{{ $type->type }}"><i class="fa fa-times-circle"></i></a>
                          <div id="deleteModal{{ $type->type }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to delete <strong>{{ $type->type }}</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                 <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                                 <a href="{{ '/project/'.$type->project_id.'/'.$type->type.'/delete'}}" class="btn btn-danger btn-delete-modal">Delete</a>
                               </div>
                              </div>
                            </div>
                          </div>
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
      @if($user->is_admin || $project->is_owner || $access->can_add_users)
        <h1>User Access</h1>
        <div class="row user-access">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <tbody>
                  @foreach($project->access as $accessor)
                    <tr>
                      <td>
                        <form role="form" method="post" action="/project/{{$project->id}}/access-remove" class="pull-right">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id" value="{{ $accessor->user_id }}">
                          <button type="submit" class="btn-delete"><i class="fa fa-times-circle"></i></button>
                        </form>
                      </td>
                      <td>{{ $accessor->user_email }}</td>
                        <form role="form" method="post" action="/project/{{$project->id}}/access">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id" value="{{ $accessor->user_id }}">
                          <input type="hidden" name="mode" value="update">
                          <td>
                            <label for="can_add_user">
                              <input type="checkbox" id="can_add_user" name="can_add_users"{{ $accessor->can_add_users ? ' checked' : ''}}> Can Add User
                            </label>
                          </td>
                          <td>
                            <label for="can_edit">
                              <input type="checkbox" id="can_edit" name="can_edit"{{ $accessor->can_edit ? ' checked' : ''}}> Can Edit
                            </label>
                          </td>
                          <td>
                            <label for="can_delete">
                              <input type="checkbox" id="can_delete" name="can_delete"{{ $accessor->can_delete ? ' checked' : ''}}> Can Delete
                            </label>
                          </td>
                          <td>
                            <button type="submit" class="btn btn-edit"><i class="fa fa-check-circle"></i> Update Access</button>
                          </td>
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
              <input type="hidden" name="mode" value="create">
                <div class="form-group">
                  <input id="email" type="text" name="email" class="form-control" placeholder="email">
                </div>
                <button type="submit" class="btn btn-primary">Add Access</button>
            </form>
          </div>
        </div>
      @endif
      </div>
    </div>
  </section>
@stop
