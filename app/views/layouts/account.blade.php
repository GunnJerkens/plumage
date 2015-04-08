@extends('master')

@section('title')
<title>Account | Plumage</title>
@stop

@section('body')
  <section id="account">
    @include('partials.message')
    <div class="container">
      <h1>Account</h1>
      <div class="row">
        <div class="col-sm-6">
          <form role="form" id="update-email" method="post" action="/account">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="form_part" value="email">
            <div class="form-group">
              <label for="email_new">New Email</label>
              <input type="email" id="email_new" class="form-control" name="email_new" placeholder="{{$user->email}}" required>
            </div>
            <div class="form-group">
              <label for="email_confirm">Confirm Email</label>
              <input type="email" id="email_confirm" class="form-control" name="email_confirm" required>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
          </form>
        </div>
        <div class="col-sm-6">
          <form role="form" id="update-password" method="post" action="/account">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="form_part" value="password">
            <div class="form-group">
              <label for="password_old">Old Password</label>
              <input type="password_old" id="password_old" class="form-control" name="password_old" required>
            </div>
            <div class="form-group">
              <label for="password_new">New Password</label>
              <input type="password_new" id="password_new" class="form-control" name="password_new" required>
            </div>
            <div class="form-group">
              <label for="password_confirm">Comfirm New Password</label>
              <input type="password_confirm" id="password_confirm" class="form-control" name="password_confirm" required>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop