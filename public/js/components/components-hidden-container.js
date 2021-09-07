 function openContainer(trigger, target){
    $("."+trigger+"").on("click", function (){
        $("#"+target+"").css("display", "block");
    });
 }

 function closeContainer(trigger, target){
    $("."+trigger+"").on("click", function (){
        $("#"+target+"").css("display", "none");
    });
 }