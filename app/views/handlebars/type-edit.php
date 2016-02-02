<script id="type-add-field" type="text/x-handlebars-template">
  <li class="field-row" data-id="{{ id }}" data-state="unsaved">
    <div class="form-group fields">
      <div class="col-sm-4">
        <label>Select a field type</label>
        <select name="{{ id }}[field_type]" class="form-control js-select-change">
          <option value="text">Text</option>
          <option value="checkbox">Checkbox</option>
          <option value="select">Select</option>
        </select>
      </div>
      <div class="col-sm-4">
        <label>Field Name</label>
        <input type="text" name="{{ id }}[field_name]" class="form-control">
      </div>
      <div class="checkbox col-sm-2">
        <label>
          <input type="checkbox" name="{{ id }}[field_editable]"> User Editable
        </label>
      </div>
      <div class="col-sm-2 delete-row no-padding">
        <a class="js-remove-field btn-delete"><i class="fa fa-times-circle"></i></a>
      </div>
    </div>
    <div class="form-group values hidden">
      <div class="col-sm-12">
        <ul class="values-group">
        </ul>
        <a class="btn btn-default js-add-value">Add Value</a>
      </div>
    </div>
  </li>
</script>
<script id="type-add-value" type="text/x-handlebars-template">
  <li class="value-row js-value-row" data-id-value="{{ valueId }}">
    <div class="form-group">
      <div class="col-sm-4">
        <label>Name</label>
        <input type="text" class="form-control" name="{{ id }}[field_values][{{ valueId }}][label]">
      </div>
      <div class="col-sm-4">
        <label>Value</label>
        <input type="text" class="form-control" name="{{ id }}[field_values][{{ valueId }}][value]">
      </div>
      <div class="col-sm-2 no-padding">
        <a class="remove btn-delete js-remove-value"><i class="fa fa-times"></i></a>
      </div>
    </div>
  </li>
</script>