@extends('master')

@section('title')
<title>Project | Plumage</title>
@stop

@section('body')
  <section id="sites-edit">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <button class="btn btn-default" id="add-field">Add Field</button>
          <form id="fields" role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul id="sortable">
            </ul>
            <button type="submit" class="btn btn-default">Update Fields</button>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop