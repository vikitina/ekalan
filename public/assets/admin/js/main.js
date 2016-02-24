$(document).ready(
     $(".tabs").tabs();

      $(".accordion-title").click(function() {
        $(this).next().slideToggle("easeOut"), $(this).toggleClass("active"), $("accordion-title").toggleClass("active"), $(".accordion-content").not($(this).next()).slideUp("easeIn"), $(".accordion-title").not($(this)).removeClass("active")
    });
     $(".accordion-content").addClass("defualt-hidden");


      $(window).scroll(function(){
                 if ($(window).scrollTop() == $(document).height() - $(window).height()){
                           /*if($(".pagenum:last").val() <= $(".rowcount").val()) {
                                       var pagenum = parseInt($(".pagenum:last").val()) + 1;
                                       getresult('getresult.php?page='+pagenum);
                                  }*/
                                  console.log('scroll');
                           }
                        });
);