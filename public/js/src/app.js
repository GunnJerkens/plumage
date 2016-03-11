var plumage;

function Plumage() {

}

Plumage.prototype.run = function() {

  // This section loads all the needed script
  //based on whether an ID exists
  if($('#type').length > 0) {
    $('#type').type({});
  }

  if($('#type-edit').length > 0) {
    $('#type-edit').typeEdit({});
  }
  
  if($('.table-fixed-header').length > 0) {
    $('.table-fixed-header').fixedHeader();
  }

}

plumage = new Plumage();
plumage.run();
