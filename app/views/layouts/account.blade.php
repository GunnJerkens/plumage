@extends('master')

@section('title')
<title>Account | Plumage</title>
@stop

@section('body')
  <section id="account" class="account">
    @include('partials.message')
    <div class="container">
      <div class="row panel">
        <h1 class="alt">Account</h1>
        <div class="col-sm-6 section">
          <form role="form" id="update-email" method="post" action="/account">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="form_part" value="email">
            <div class="form-group">
              <label for="email_new" class="sr-only">New Email</label>
              <input type="email" id="email_new" class="form-control" name="email_new" placeholder="New Email" required>
            </div>
            <div class="form-group">
              <label for="email_confirm" class="sr-only">Confirm Email</label>
              <input type="email" id="email_confirm" class="form-control" name="email_confirm" placeholder="Confirm Email" required>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
          </form>
        </div>
        <div class="col-sm-6 section">
          <form role="form" id="update-password" method="post" action="/account">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="form_part" value="password">
            <div class="form-group">
              <label for="password_old" class="sr-only">Old Password</label>
              <input type="password" id="password_old" class="form-control" name="password_old" placeholder="Old Password" required>
            </div>
            <div class="form-group">
              <label for="password_new" class="sr-only">New Password</label>
              <input type="password" id="password_new" class="form-control" name="password_new" placeholder="New Password" required>
            </div>
            <div class="form-group">
              <label for="password_confirm" class="sr-only">Comfirm New Password</label>
              <input type="password" id="password_confirm" class="form-control" name="password_confirm" placeholder="Confirm New Password" required>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop