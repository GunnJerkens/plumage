$(document).ready(function() {

  $('.new-item').on('click', function() {
    var rowID, rowHTML;

    rowID = $('tbody').children().length;

    rowHTML = '<tr dataid="' + rowID + '">';

    console.log(fields);

    for(var i = 0; i < fields.length; i++) {
      rowHTML += '<td>';
      if(fields[i].field_name === 'text' || fields[i].field_name === 'checkbox') {
        rowHTML += '<input type="' + fields[i].field_type + '" name="' + rowID + '[' + fields[i].field_name + ']">';
      } else if(fields[i].field_name === 'select') {
        rowHTML += '<select name="' + rowID + '[' + fields[i].field_name + ']">';
        for(var j = 0; j < fields[i].field_values.length; j ++) {
          rowHTML += '<option value="' + fields[i].field_values[j].value + '">' + fields[i].field_values[j].label + '</option>';
        }
        rowHTML += '</select>';
      } else {
        console.log('nope');
      }
      rowHTML += '</td>';
    }

    rowHTML += '</tr>';

    $('tbody').append(rowHTML);

    return false;
  });

});