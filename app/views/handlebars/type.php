<script id="type-new-item" type="text/x-handlebars-template">
  <tr data-id="{{ id }}">
    <input type="hidden" name="{{ id }}[id]" value="{{ id }}" class="form-control">
    <td><a href class="js-delete-type btn-delete" data-id="new"><i class="fa fa-times-circle"></i></a>
    {{#each fields}}
      <td>{{dofields @index}}</td>
    {{/each}}
  </tr>
</script>