function previewFile(input) {
    var file = $('.img_preview').get(0).files[0];
    console.log(file);
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $('#previewimg').attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}