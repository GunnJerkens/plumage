$(document).ready(function() {

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
    var id, fieldRow;

    id = $('#sortable').children().length;

    fieldRow = [
      '<li class="field-row" data-id="' + id + '">',
        '<div class="form-group fields">',
          '<div class="col-sm-4"',
            '<label>Select a field type</label>',
            '<select name="' + id + '[field_type]" class="form-control select-change">',
              '<option value="text">Text</option>',
              '<option value="checkbox">Checkbox</option>',
              '<option value="select">Select</option>',
            '</select>',
          '</div>',
          '<div class="col-sm-4">',
            '<label>Field Name</label>',
            '<input type="text" name="' + id + '[field_name]" class="form-control">',
          '</div>',
          '<div class="checkbox col-sm-2">',
            '<label>',
              '<input type="checkbox" name="' + id + '[field_editable]"> User Editable',
            '</label>',
          '</div>',
          '<div class="col-sm-2">',
            '<a class="remove btn btn-danger">Remove Field</a>',
          '</div>',
        '</div>',
        '<div class="form-group values hidden">',
          '<div class="col-sm-12">',
            '<ul class="values-group">',
            '</ul>',
            '<a class="btn btn-default add-value">Add Value</a>',
          '</div>',
        '</div>',
      '</li>'
    ].join("\n");

    $('#sortable').append(fieldRow);
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
    var id, valueID, valueRow;

    id      = $(this).closest('li.field-row').data('id');
    valueID = $(this).siblings('ul.values-group').children().length;

    valueRow = [
      '<li class="value-row">',
        '<div class="form-group">',
          '<div class="col-sm-4">',
            '<label>Value</label>',
            '<input type="text" class="form-control" name="' + id + '[field_values][' + valueID + '][value]">',
          '</div>',
          '<div class="col-sm-4">',
            '<label>Name</label>',
            '<input type="text" class="form-control" name="' + id + '[field_values][' + valueID + '][label]">',
          '</div>',
          '<div class="col-sm-2">',
            '<a class="remove btn btn-danger">Remove Value</a>',
          '</div>',
        '</div>',
      '</li>',
    ].join("\n");

    $(this).siblings('ul.values-group').append(valueRow);
    return false;
  });

  $sortable.on('click', 'a.remove', function() {
    $(this).closest('li').remove();
  });

});