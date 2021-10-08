function changeProfilePic(input, output) {
    if (input.files && input.files[0]) {
        var reader   = new FileReader();
        var result = [];
        reader.onload = function (e) {
            $('#profileImage').attr('src', e.target.result);
            result.push(e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        return result;
    }
}

function createImageCard(input, createdCardNumber) {
    if (input.files && input.files[0]) {
        var reader   = new FileReader();

        reader.onload = function (e) {
            var element = "  <div class=\"col-11 col-md-6 col-lg-4 p-0 o-margin--t--2 new-image\" id="+createdCardNumber+">\n" +
                "                    <div class=\"c-project-images__addImages-holder__image-holder col-11 mx-auto\">\n" +
                "                        <img src='"+e.target.result+"' alt=\"\" class=\"\">\n" +
                "                        <div class=\"remove-image\"><i class=\"fas fa-times\"></i></div>\n" +
                "                    </div>\n" +
                "                </div>"
            $('#projectImagesContainer').before(element);

        }

        reader.readAsDataURL(input.files[0]);
    }
}



