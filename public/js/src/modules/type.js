/**
 * This is the type module, it controls all the javascript aspects of
 * editing the types data
 *
 */

/**
 * Declare our class Type
 *
 * @return void
 */
function Type(el, options) {
  this.el      = el;
  this.options = options;
  this.token   = $("meta[name='token']").attr('content');
}

/**
 * Loads the standard type functionality
 *
 * @return void
 */
Type.prototype.loadType = function() {
  this.loadTypeClickHandlers();
};

/**
 * Loads the click handlers throughout the page
 *
 * @return void
 */
Type.prototype.loadTypeClickHandlers = function() {
  var _this = this, newId = 0;

  $('.js-new-item').on('click', function(e) {
    e.preventDefault();
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
          for(var key in this.field_values) {
            string += '<option value="' + this.field_values[key].value + '">' + this.field_values[key].label + '</option>';
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
  });

  $('#type').on('click', '.js-delete-type', function(e) {
    e.preventDefault();
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
          return request.setRequestHeader("X-CSRF-Token", _this.token);
        },
        success: function(data) {
          console.log(data);
        },
        error: function(xhr, textStatus, thrownError) { console.log('Silent failure.'); }
      });
    }
    $(this).closest('tr').remove();
  });

};

/**
 * Loads the functionality for editing a type
 *
 * @return void
 */
Type.prototype.loadTypeEdit = function() {
  var $sortable = $('#sortable');

  if($sortable.length > 0) {
    this.setSortable($sortable);
  }

  this.loadTypeEditClickHandlers($sortable);
};

/**
 * Sets the sortable method on the fields
 *
 * @return void
 */
Type.prototype.setSortable = function($sortable) {
  $sortable.sortable();
  $('.value-sortable').sortable();
};

/**
 * Loads the click handlers throughout the page
 *
 * @return void
 */
Type.prototype.loadTypeEditClickHandlers = function($sortable) {
  var _this = this;

  $('.js-add-field').on('click', function(e) {
    e.preventDefault();
    var data = {
      id: $('li.field-row').length + 1 || 0
    },
    source   = $('#type-add-field').html(),
    template = Handlebars.compile(source);

    $sortable.append(template(data));
  });

  $sortable.on('change', 'select.js-select-change', function(e) {
    e.preventDefault();
    var $valueDiv = $(this).closest('div.fields').siblings('div.values');

    if($(this).val() === 'select') {
      $valueDiv.removeClass('hidden');
    } else {
      $valueDiv.addClass('hidden');
    }
  });

  $sortable.on('click', '.js-add-value', function(e) {
    e.preventDefault();
    var data = {
      id:      $(this).closest('li.field-row').data('id'),
      valueId: $(this).siblings('ul.values-group').children().length
    },
    source   = $('#type-add-value').html(),
    template = Handlebars.compile(source);


    $(this).siblings('ul.values-group').append(template(data));
  });

  $sortable.on('click', '.js-remove-field', function(e) {
    e.preventDefault();
    var column = $(this).data('column') || false;

    if(column !== false) {
      $.ajax({
        url: window.location.href + '/delete-field',
        type: 'post',
        cache: false,
        dataType: 'json',
        data: 'column=' + column,
        beforeSend: function(request) {
          $("form#invite-user .message").empty();
          return request.setRequestHeader("X-CSRF-Token", _this.token);
        },
        success: function(data) {
          console.log(data);
        },
        error: function(xhr, textStatus, thrownError) { console.log('Silent failure.'); }
      });
    }
    $(this).closest('li').remove();
  });
};

/**
 * Load jquery methods to interact on el
 *
 * @return void
 */
$.fn.type = function(options) {
  var type = new Type($(this), options);
  type.loadType();
};

/**
 * Load jquery methods to interact on el
 *
 * @return void
 */
$.fn.typeEdit = function(options) {
  var type = new Type($(this), options);
  type.loadTypeEdit();
};
