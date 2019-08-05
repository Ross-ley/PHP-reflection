/*pure javascript*/
function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginRight = "250px";
  }
  
  /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginRight = "0";
  }

/*Jquery*/
// $('body').on('click', function(){
//     if( parseInt( $('#mySidenav').css('width') ) > 0 ){
//       closeNav();
//     }
//   });

// $(document).ready(function(){

//     $("fa-star").on(click, function {
//         $("fa-star").addClass("active_star");
//         $("fa-star").removeClass("disactive_star");
//     })
    
//     $("fa-star").on(click, function {
//         $("fa-star").addClass("disactive_star");
//         $("fa-star").removeClass("active_star");
//     })
// });

$('.anime').click(function(e){
    $(e.target).toggleClass('disactive_star active_star')
});

$('.manga').click(function(e){
    $(e.target).toggleClass('disactive_star active_star')
});


$(document).ready(function(){
    if ($("div").hasClass("Main")){
        $('#home').addClass("active");
    } else if ($("div").hasClass("second")){
        $("#login").addClass("active");
        $("#home").removeClass("active");
    } else if ($("div").hasClass("third")){
        $("#contact").addClass("active");
        $("#home").removeClass("active");
    } else {
        $("#logedIn").addClass("active");
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

$(function () {

    $('#contact-form').validator();

    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = "contact-3.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    // data = JSON object that contact.php returns

                    // we recieve the type of the message: success x danger and apply it to the 
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact-form').find('.messages').html(alertBox);
                        // empty the form
                        $('#contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
}); 

$(function () {

    $('user.php').validator();

    // when the form is submitted
    $('.anime, .manga').on('click', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = "ajax-call/anime-likes.php";
// console.log($(e.target).parent().hasClass('animeStar'));
            // POST values in the background the the script URL
            if ($(e.target).parent().hasClass('animeStar')) {
                var table = 1;
            } else {
                var table = 2;
            }

            $.ajax({
                type: "POST",
                url: url,
                data: { 'id': $(e.target).data('id'), 'table': table },
                success: function (data)
                {
                    // console.log(data);
                }
            });
            return false;
        }
    })
});

