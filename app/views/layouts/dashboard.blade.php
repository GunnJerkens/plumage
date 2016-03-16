@extends('master')

@section('title')
<title>Dashboard | Plumage</title>
@stop

@section('body')
  <section id="dashboard" class="dashboard">
    @include('partials.message')
    <div class="container view">
      <div class="row">
        <div class="col-sm-12">
          <form role="form" method="post" class="addForm">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <label for="project_name" class="sr-only">Add Project</label>
            <input type="text" id="project_name" class="form-control" placeholder="project name" name="project_name"{{ Session::has('input_text') ? 'value="'.(Session::get('input_text')).'"' : '' }}>
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
                        <form role="form" action="{{ '/project/'.$project->id.'/delete' }}" method="post">
                          <button type="button" class="btn-delete" data-toggle="modal" data-target="#deleteModal{{ $project->id }}"><i class="fa fa-times-circle"></i></button>
                          <div id="deleteModal{{ $project->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to delete <strong>{{ $project->name}}</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                 <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}"><button class=" btn btn-danger">Delete</button>
                               </div>
                              </div>
                            </div>
                          </div>
                        </form>
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
