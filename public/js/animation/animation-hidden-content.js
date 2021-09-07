$('.c-add-project__button-container__button').on('click', function(){
    $('.c-add-project__content-container').css('display', 'block');
    console.log("button is clicked");
});


$('.c-add-project__content-container__content__close-button').on('click', function(){
    $('.c-add-project__content-container').css('display', 'none');
    console.log("x is clicked");
});