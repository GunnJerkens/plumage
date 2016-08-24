@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <script>var fields = {{ json_encode($fields) }};</script>
  <section id="type" class="project">
    @include('partials.message')
    <div class="container view">
      <div class="row">
        <div class="col-sm-12">
          @if(sizeof($fields) > 0)
          <form role="form" method="post" class="manageType">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
              <div class="col-sm-12">
                @include('partials.breadcrumbs')
                <button type="submit" class="btn btn-save btn-primary pull-right">Save</button>
                <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#bulk-upload">Bulk Upload</button>
                @if($user->is_admin || $project->is_owner || $access->can_delete)
                  <a class="btn btn-default new-item js-new-item pull-right">New Item</a>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-inner-wrapper">
                  <div class="table-fixed-header-wrap">
                    <table class="table table-striped table-bordered table-fixed-header">
                      <thead>
                        <tr>
                          @if($user->is_admin || $project->is_owner || $access->can_delete)
                            <td>Delete</td>
                          @endif
                          @foreach($fields as $field)
                            <td>{{ $field->field_name }}</td>
                          @endforeach
                        </tr>
                      </thead>
                    </table>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          @if($user->is_admin || $project->is_owner || $access->can_delete)
                            <td>Delete</td>
                          @endif
                          @foreach($fields as $field)
                            <td>{{ $field->field_name }}</td>
                          @endforeach
                        </tr>
                      </thead>
                      <tbody>
                      @if(sizeof($items) > 0)
                        @foreach($items as $item)
                          <tr data-id="{{ $item->id }}">
                            <input type="hidden" name="{{ $item->id }}[id]" value="{{ $item->id }}">
                            @if($user->is_admin || $project->is_owner || $access->can_delete)
                              <td>
                                <a tabindex="0" class="btn-delete" role="button" data-toggle="popover" data-container="#type" data-trigger="focus" data-html="true" title="<strong>Confirm Delete</strong>" data-content='<p>Are you sure you want to delete this item?</p><a role="button" data-id="{{ $item->id }}" class="js-delete-type btn btn-danger btn-delete-modal btn-block">Delete</a>'><i class="fa fa-times-circle"></i></a>
                              </td>
                            @endif
                            @foreach($fields as $field)
                              @if(property_exists($item, $field->field_name))
                                @if($field->field_type === 'text')
                                  <td style="min-width:{{ (strlen($item->{$field->field_name}) * 14) + 22 }}px;">
                                    <input type="text" name="{{ $item->id }}[{{ $field->field_name }}]" value="{{ $item->{$field->field_name} }}" class="form-control" {{ $user->hasAccess(['manage']) || isset($field->field_editable) && $field->field_editable === 'on' ? '' : ' disabled' }}>
                                  </td>
                                @elseif($field->field_type === 'checkbox')
                                  <td>
                                    @if($user->hasAccess(['manage']) || isset($field->field_editable) && $field->field_editable === 'on')
                                      <input type="checkbox" name="{{ $item->id }}[{{ $field->field_name }}]"{{ $item->{$field->field_name} ? ' checked' : '' }} value="1">
                                    @else
                                      <input type="checkbox"{{ $item->{$field->field_name} ? ' checked' : '' }} disabled>
                                      <input type="checkbox" class="hidden" name="{{ $item->id }}[{{ $field->field_name }}]"{{ $item->{$field->field_name} ? ' checked' : '' }} value="1">
                                    @endif
                                  </td>
                                @elseif($field->field_type === 'select')
                                  <td>
                                    <select name="{{ $item->id }}[{{ $field->field_name }}]"{{ $user->hasAccess(['manage']) || isset($field->field_editable) && $field->field_editable === 'on' ? '' : ' disabled' }}>
                                      @foreach($field->field_values as $option)
                                        <option value="{{ $option->value }}"{{ $option->value === $item->{$field->field_name} ? ' selected' : '' }}>{{ $option->label }}</option>
                                      @endforeach
                                    </select>
                                  </td>
                                @endif
                              @else
                                <td>{{ $field->field_name }}</td>
                              @endif
                            @endforeach
                          </tr>
                        @endforeach
                      @else
                        <table id="no-data">
                          <tr>
                            <td>No data available.</td>
                          </tr>
                        </table>
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row bottom-buttons">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-save btn-primary pull-right">Save</button>
                @if($user->is_admin || $project->is_owner || $access->can_delete)
                  <a class="btn btn-default new-item js-new-item pull-right">New Item</a>
                @endif
              </div>
            </div>
          </form>
          @else
            @include('partials.breadcrumbs')
            <h1>You need to create fields before you can add data.</h1>
          @endif
        </div>
      </div>
    </div>
  </section>
  <!-- Modal -->
  <div class="modal fade" id="bulk-upload" data-backdrop="true" data-keyboard="true" data-show="false" tabindex="-1" role="dialog" aria-labelledby="bulk-upload" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Bulk JSON Upload</h4>
        </div>
        <form role="form" method="post" action="{{ '/project/'.$project->project_id.'/'.$project->type.'/bulk' }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="modal-body">
            <textarea name="json_data" placeholder="Only valid json accepted" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @include('handlebars.type')
@stop
