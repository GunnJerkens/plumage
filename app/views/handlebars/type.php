<script id="type-new-item" type="text/x-handlebars-template">
  <tr data-id="{{ id }}">
    <input type="hidden" name="{{ id }}[id]" value="{{ id }}">
    {{#each fields}}
      <td>{{dofields @index}}</td>
    {{/each}}
  </tr>
</script>