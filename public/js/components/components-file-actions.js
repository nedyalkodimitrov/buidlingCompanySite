function readURL(input, output) {
    if (input.files && input.files[0]) {
        var reader   = new FileReader();

        reader.onload = function (e) {
            $('#profileImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function createImageCard(input) {
    if (input.files && input.files[0]) {
        var reader   = new FileReader();

        reader.onload = function (e) {
            var element = "  <div class=\"col-11 col-md-6 col-lg-4 p-0 o-margin--t--1 new-image\">\n" +
                "                    <div class=\"c-project-images__addImages-holder__image-holder col-11 mx-auto\">\n" +
                "                        <img src='"+e.target.result+"' alt=\"\" class=\"new-image\">\n" +
                "                    </div>\n" +
                "                </div>"
            $('#projectImagesContainer').before(element);
            $('#profileImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}