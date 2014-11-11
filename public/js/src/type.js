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

    for(var key in fields) {
      rowHTML += '<td>';
      if(fields[key].field_type === 'text' || fields[key].field_type === 'checkbox') {
        rowHTML += '<input type="' + fields[key].field_type + '" name="' + rowID + '[' + fields[key].field_name + ']">';
      } else if(fields[key].field_type === 'select') {
        rowHTML += '<select name="' + rowID + '[' + fields[key].field_name + ']">';
        for(var j = 0; j < fields[key].field_values.length; j ++) {
          rowHTML += '<option value="' + fields[key].field_values[j].value + '">' + fields[key].field_values[j].label + '</option>';
        }
        rowHTML += '</select>';
      }
      rowHTML += '</td>';
    }
    rowHTML += '</tr>';

    console.log(rowHTML);

    $('tbody').append(rowHTML);

    return false;
  });

});