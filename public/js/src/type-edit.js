;(function($) {

  var $sortable;

  $sortable = $('#sortable');

  if($sortable.length > 0) {
    setSortable();
  }

  function setSortable() {
    $sortable.sortable();
    $('.value-sortable').sortable();
  }

  $('#add-field').on('click', function() {
    var source, template, data;

    data = { 
      id: $('li.field-row').last().data('id') + 1 || 0
    };
    source   = $('#type-add-field').html();
    template = Handlebars.compile(source);

    $('#sortable').append(template(data));
    return false;
  });

  $sortable.on('change', 'select.select-change', function() {
    var $valueDiv;

    $valueDiv = $(this).closest('div.fields').siblings('div.values');

    if($(this).val() === 'select') {
      $valueDiv.removeClass('hidden');
    } else {
      $valueDiv.addClass('hidden');
    }
    return false;
  });

  $sortable.on('click', 'a.add-value', function() {
    var source, template, data;

    data     = {
      id:      $(this).closest('li.field-row').data('id'),
      valueId: $(this).siblings('ul.values-group').children().length
    };
    source   = $('#type-add-value').html();
    template = Handlebars.compile(source);

    $(this).siblings('ul.values-group').append(template(data));
    return false;
  });

  $sortable.on('click', 'a.remove-field', function(e) {
    var column = $(this).data('column') || false;

    e.preventDefault();

    if(column !== false) {
      $.ajax({
        url: window.location.href + '/delete-field',
        type: 'post',
        cache: false,
        dataType: 'json',
        data: 'column=' + column,
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
    $(this).closest('li').remove();
  });

})(jQuery);