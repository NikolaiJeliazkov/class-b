<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td><i class="glyphicon glyphicon-paperclip"></i></td>
        <td class="delete">
            <a href="#" data-toggle="tooltip" title="{%=locale.fileupload.destroy%}" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="glyphicon glyphicon-trash"></i>
            </a>
        </td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="doc-type"><span>{%=file.docType%}</span></td>
        {% if (file.error) { %}
            <td class="error"><span class="label label-danger">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td></td>
        {% } %}
    </tr>
{% } %}
</script>
