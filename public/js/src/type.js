;(function($) {

  var newId = 0;

  $('#bulk-upload').modal({
    backdrop: true,
    keyboard: true,
    show: false
  });

  $('.new-item').on('click', function() {
    var source, template, data, id;

    id     = 'new' + newId;
    data   = { id: id, fields: fields }
    source = $('#type-new-item').html();

    Handlebars.registerHelper('dofields', function(i) {
      var string = '';
      switch(this.field_type) {
        case('text'):
        case('checkbox'):
          string += '<input type="' + this.field_type + '" name="' + id + '[' + this.field_name + ']">';
          break;
        case('select'):
          string += '<select name="' + id + '[' + this.field_name + ']">';
          for(var j = 0; j < this.field_values.length; j++) {
            string += '<option value="' + this.field_values[j].value + '">' + this.field_values[j].label + '</option>';
          }
          string += '</select>';
          break;
      }
      return new Handlebars.SafeString(string);
    });

    template = Handlebars.compile(source);
    $('table#no-data').remove();
    $('tbody').append(template(data));
    newId++;
    return false;
  });

  $('#project').on('click', '.delete-type', function(e) {
    var id = $(this).attr('data-id');
    if('new' !== id.substring(0,3)) {
      $.ajax({
        url: window.location.href + '/delete-row',
        type: 'post',
        cache: false,
        dataType: 'json',
        data: 'row=' + id,
        beforeSend: function(request) {
          $("form#invite-user .message").empty();
          return request.setRequestHeader("X-CSRF-Token", $("meta[name='token']").attr('content'));
        },
        success: function(data) {
          console.log(data);
        },
        error: function(xhr, textStatus, thrownError) { console.log('Silent failure.'); }
      });
    }
    $(this).closest('tr').remove();
    return false;
  });

})(jQuery);