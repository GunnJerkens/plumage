;(function() {

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

    data     = { id: $('#sortable').children().length };
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

  $sortable.on('click', 'a.remove', function() {
    $(this).closest('li').remove();
  });

})();