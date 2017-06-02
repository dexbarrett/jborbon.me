var imagesLoaded = false;
var albumModal = $('#album-images-modal');
var albumModalBody = albumModal.find('.modal-body').first();
var albumImages = null;

function getSelectedImages()
{  
    return albumImages.find('option:selected').map(function () {
        return '[image]' + $(this).data('img-src') + '[/image]';
    }).toArray();

}

function clearImageSelection()
{
    albumImages.find('option:selected').prop('selected', false);
    albumImages.data('picker').sync_picker_with_select();
}

function disableInsertButton(disabled)
{
    $('#insert-images').prop('disabled', disabled);
}

function insertImages(imageUrlsArray)
{
    if (imageUrlsArray.length > 0) {
        $('#post-content').insertAtCaret(imageUrlsArray.join('\n'));
    }
}

function imageSelectionChanged(select, newValues, oldValues, event)
{
    var disabled = (newValues.length == 0);
    disableInsertButton(disabled);
}

function loadImages(getImagesURL)
{
    if (imagesLoaded) { return; }

    albumModalBody.empty();

    albumModalBody.LoadingOverlay('show', {
        image       : '',
        fontawesome : 'fa fa-spinner fa-spin'
    });

    $.ajax({
        url: getImagesURL,
        type: 'GET',
        cache: false,
    })
    .done(function (data, textStatus, jqXHR) {
        var images = $(Mustache.render(
                                $('#album-template').html(), { images: data }
                          ));
        images.appendTo(albumModalBody);
        $('.image-picker').imagepicker({
            changed: imageSelectionChanged
        });
        imagesLoaded = true;
        albumImages = $('#album-images');
        
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('algo salio mal');
    })
    .always(function () {
        albumModalBody.LoadingOverlay("hide");
    });
}

albumModal.on('shown.bs.modal', function (e) {
    loadImages(albumImagesRoute);
});

albumModal.on('hidden.bs.modal', function (e) {
    clearImageSelection();
    disableInsertButton(true);
});

$('#insert-images').on('click', function () {
    insertImages(getSelectedImages());
    albumModal.modal('hide');
});
