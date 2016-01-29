$(document).ready(
     $(".tabs").tabs();

      $(".accordion-title").click(function() {
        $(this).next().slideToggle("easeOut"), $(this).toggleClass("active"), $("accordion-title").toggleClass("active"), $(".accordion-content").not($(this).next()).slideUp("easeIn"), $(".accordion-title").not($(this)).removeClass("active")
    });
     $(".accordion-content").addClass("defualt-hidden");

);