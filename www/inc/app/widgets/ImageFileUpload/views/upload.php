<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td><i class="glyphicon glyphicon-paperclip"></i></td>
        <td class="cancel">{% if (!i) { %}
            <a href="#" data-toggle="tooltip" title="{%=locale.fileupload.destroy%}">
                <i class="glyphicon glyphicon-trash"></i>
            </a>
        {% } %}</td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td></td>
        {% if (file.error) { %}
            <td class="error"><span class="label label-danger">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress"><div class="progress-bar progress-bar-striped active" style="width:0%;"></div></div>
            </td>
        {% } else { %}
            <td></td>
        {% } %}
    </tr>
{% } %}
</script>
