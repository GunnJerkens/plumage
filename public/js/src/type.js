$(document).ready(function() {

  $('.new-item').on('click', function() {
    var rowsArr, rowID, rowHTML;
    rowsArr = [];

    $('tbody').children().each(function() {
      rowsArr.push($(this).data('id'));
    });
    rowID = rowsArr.slice(-1).pop() + 1;

    rowHTML = '<tr data-id="' + rowID + '">';
    rowHTML += '<input type="hidden" name="' + rowID + '[id]" value="' + rowID + '">';

    for(var i = 0; i < fields.length; i++) {
      rowHTML += '<td>';
      if(fields[i].field_type === 'text' || fields[i].field_type === 'checkbox') {
        rowHTML += '<input type="' + fields[i].field_type + '" name="' + rowID + '[' + fields[i].field_name + ']">';
      } else if(fields[i].field_type === 'select') {
        rowHTML += '<select name="' + rowID + '[' + fields[i].field_name + ']">';
        for(var j = 0; j < fields[i].field_values.length; j ++) {
          rowHTML += '<option value="' + fields[i].field_values[j].value + '">' + fields[i].field_values[j].label + '</option>';
        }
        rowHTML += '</select>';
      }
      rowHTML += '</td>';
    }
    rowHTML += '</tr>';

    $('tbody').append(rowHTML);

    return false;
  });

});