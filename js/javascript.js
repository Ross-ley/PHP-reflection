/*pure javascript*/

/*Jquery*/
$(document).ready(function(){
    if ($("div").hasClass("Main")){
        $('#home').addClass("active");
    } else if ($("div").hasClass("second")){
        $("#login").addClass("active");
        $("#home").removeClass("active");
    } else if ($("div").hasClass("third")){
        $("#contact").addClass("active");
        $("#home").removeClass("active");
    }
});
$(document).ready(function(){
    if ($("div").hasClass("second")){
        $('footer').addClass("bottom");
    } else if ($("div").hasClass("third")){
        $('footer').addClass("bottom");
    } else if ($("div").hasClass("reg")){
        $('footer').addClass("bottom");
    }
});
