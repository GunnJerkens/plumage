@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="sites-edit" class="sites-edit">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12 add-fields">
          <button class="btn btn-default pull-right js-add-field">Add Field</button>
          <form id="fields" role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul id="sortable">
            @if(sizeof($fields) > 0)
              @foreach($fields as $key=>$value)
              <li class="field-row" data-id="{{ $key }}">
                <div class="form-group fields">
                  <div class="col-sm-4">
                    <label>Select a field type</label>
                    <select name="{{ $key }}[field_type]" class="form-control js-select-change">
                      <option value="text"{{ $value->field_type === 'text' ? ' selected' : '' }}>Text</option>
                      <option value="checkbox"{{ $value->field_type === 'checkbox' ? ' selected' : '' }}>Checkbox</option>
                      <option value="select"{{ $value->field_type === 'select' ? ' selected' : '' }}>Select</option>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>Field Name</label>
                    <input type="text" name="{{ $key }}[field_name]" class="form-control" value="{{ $value->field_name }}">
                    <input type="hidden" name="{{ $key }}[field_name_orig]" value="{{ $value->field_name }}" class="hidden">
                  </div>
                  <div class="checkbox col-sm-2">
                    <label>
                      <input type="checkbox" name="{{ $key }}[field_editable]"{{ isset($value->field_editable) && $value->field_editable === 'on' ? ' checked' : '' }}> User Editable
                    </label>
                  </div>
                  <div class="col-sm-2 haha no-padding">
                    <a class="js-remove-field btn btn-danger" data-column="{{ $value->field_name }}">Remove Field</a>
                  </div>
                </div>
                <div class="form-group values{{ isset($value->field_values) ?: ' hidden' }}">
                  <div class="col-sm-12">
                    <ul class="values-group">
                    @if(isset($value->field_values) && sizeof($value->field_values) > 0)
                      @foreach($value->field_values as $index=>$pair)
                        <li class="value-row">
                          <div class="form-group">
                            <div class="col-sm-4">
                              <label>Name</label>
                              <input type="text" class="form-control" name="{{ $key }}[field_values][{{ $index }}][label]" value="{{ $pair->label }}">
                            </div>
                            <div class="col-sm-4">
                              <label>Value</label>
                              <input type="text" class="form-control" name="{{ $key }}[field_values][{{ $index }}][value]" value="{{ $pair->value }}">
                            </div>
                            <div class="col-sm-2 no-padding">
                              <a class="remove btn btn-danger">Remove Value</a>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    @endif
                    </ul>
                    <a class="btn btn-default js-add-value">Add Value</a>
                  </div>
                </div>
              </li>
              @endforeach
            @endif
            </ul>
            <button type="submit" class="btn btn-success pull-right">Update Fields</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  @include('handlebars.type-edit')
@stop