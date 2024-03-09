function previewImage(input, imageId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#' + imageId).attr('src', e.target.result);
            $('#' + imageId).show(); // Show the image preview
        }

        reader.readAsDataURL(input.files[0]);
    }
}
