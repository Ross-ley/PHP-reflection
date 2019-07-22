/*pure javascript*/

/*Jquery*/
$(document).ready(function(){
    if ($("div").hasClass("Main")){
        $('#home').addClass("active");
    } else if ($("div").hasClass("second")){
        $("#login").addClass("active");
        $("#home").removeClass("active");
    } else {
        $("#register").addClass("active");
        $("#home").removeClass("active");
    }
});
