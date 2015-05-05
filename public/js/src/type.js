;(function($) {

  $('#bulk-upload').modal({
    backdrop: true,
    keyboard: true,
    show: false
  });

  $('.new-item').on('click', function() {
    var source, template, data, id;

    id     = $('tbody').children().length + 1;
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
    $('tbody').append(template(data));
    return false;
  });

  $('#project').on('click', '.delete-type', function() {
    var id = $(this).data('id');
    if('new' !== id) {
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