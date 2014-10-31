@if(Session::has('error'))
  <div class="container">
    <div class="alert {{ Session::get('error') ? 'alert-danger' : 'alert-success' }}" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      {{ Session::get('message') }}
    </div>
  </div>
@endif