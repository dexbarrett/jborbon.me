function enableInlineAttachments(uploadUrl, jsonFieldName, uploadFieldName)
{
     $('.inline-attachment').inlineattachment({
        uploadUrl: uploadUrl,
        jsonFieldName: jsonFieldName,
        uploadFieldName: uploadFieldName,
        urlText: '[image]{filename}[/image]',
        progressText: '[subiendo imagen...]',
        extraHeaders: {
            'X-Requested-With': 'XMLHttpRequest'
        },

        onFileUploadError: function(response) {
            if (response.status >= 400 && response.status < 500) {
                alert('Necesitas autenticarte con Imgur para subir imágenes');
            }
        }
    }); 
}