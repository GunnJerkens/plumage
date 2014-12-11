@extends('master')

@section('title')
<title>Manage | Plumage</title>
@stop

@section('body')
  <section id="manage">
    @include('partials.message')
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Users</h1>
          <table class="table">
            <thead>
              <tr>
                <td>Email</td>
                <td>Projects</td>
                <td>Delete</td>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td>{{{ $user->email }}}</td>
                  <td><textarea>{{{ $user->access }}}</textarea></td>
                  <td>
                    <form role="form" method="post" action="/manage/ban">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="user_id" value="{{{ $user->id }}}">
                      <button class="btn btn-danger">{{{ $throttle->isBanned() ? 'Unban' : 'Ban' }}}</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table> 
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <h1>Add User</h1>
          <form role="form" id="add-user" method="post" action="/manage/create">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="email">Email</label>s
              <input type="email" id="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
              <label for="group">Group</label>
              <select id="group" name="group" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <button type="submit" class="btn btn-default">Create</button>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop