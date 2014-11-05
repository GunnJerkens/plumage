@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <script>var fields = {{ json_encode($fields) }};</script>
  <section id="project">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          @if(sizeof($fields) > 0)
          <form role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table table-striped">
              <thead>
                <tr>
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
                    @foreach($fields as $field)
                      @if($field->field_type === 'text')
                        <td>
                          <input type="text" name="{{ $item->id }}[{{ $field->field_name }}]" value="{{ $item->{$field->field_name} }}">
                        </td>
                      @elseif($field->field_type === 'checkbox')
                        <td>
                          <input type="checkbox" name="{{ $item->id }}[{{ $field->field_name }}]">
                        </td>
                      @elseif($field->field_type === 'select')
                        <td>
                          <select name="{{ $item->id }}[{{ $field->field_name }}]">
                            @foreach($field->field_values as $option)
                              <option value="{{ $option->value }}">{{ $option->label }}</option>
                            @endforeach
                          </select>
                        </td>
                      @endif
                    @endforeach
                  </tr>
                @endforeach
              @else
                <tr data-id="0">
                  <input type="hidden" name="0[id]" value="0">
                  @foreach($fields as $field)
                    @if($field->field_type === 'text')
                      <td>
                        <input type="text" name="0[{{ $field->field_name }}]">
                      </td>
                    @elseif($field->field_type === 'checkbox')
                      <td>
                        <input type="checkbox" name="0[{{ $field->field_name }}]">
                      </td>
                    @elseif($field->field_type === 'select')
                      <td>
                        <select name="0[{{ $field->field_name }}]">
                          @foreach($field->field_values as $option)
                            <option value="{{ $option->value }}">{{ $option->label }}</option>
                          @endforeach
                        </select>
                      </td>
                    @endif
                  @endforeach
                </tr>
              @endif
              </tbody>
            </table>
            <button type="submit" class="btn btn-default">Save</button>
          </form>
          <a href class="btn btn-default new-item">New Item</a>
          @else
            <h1>You need to create fields before you can add data.</h1>
          @endif
        </div>
      </div>
    </div>
  </section>
@stop