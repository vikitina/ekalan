jQuery(document).ready(function($) {
    $('.testimonial-slider').bxSlider({
					pager:true,
					controls: false,
					auto : 'true', 
					});

    $('.ak_footer_social .social-icons > a').each(function(){
    	$(this).wrap('<span></span>');
    });
    
    //Search Box Toogle
    $('.search-icon .fa-search').click(function(){
    $('.ak-search').slideToggle('slow');
    });
  
    $('.ak_footer_social .social-icons a').hover(function() {
      $(this).addClass('animated subtleBounce');
    }, function() {
      $(this).removeClass('animated subtleBounce');
    });

    $('.our-services .service-icons a').hover(function() {
      $(this).addClass('animated pulse');
    }, function() {
      $(this).removeClass('animated pulse');
    });

    $('.error404 .number404').addClass('animated bounce');


    $('.scroll').bxSlider({
        pager:false,
    		controls: true,
    		auto : 'true',
        minSlides: 2,
        maxSlides: 6,
        slideWidth: 170,
        slideMargin: 10   
    });
    
     
    $('.counter').counterUp({
      delay: 10,
      time: 1000
    });
    

    $('.menu-toggle').click(function() {
      $('.menu-main-menu-container').toggle('slow');
    });

    $('#ak-top').hide();
    $(window).scroll(function(){
      if($(this).scrollTop() > 300){
        $('#ak-top').fadeIn();
      }else{
        $('#ak-top').fadeOut();
      }
    });
  
    $("#ak-top").click(function(){
      $('html,body').animate({scrollTop:0},600);
    });
  
    $('.search-close').on('click', function(){
      $('.ak-search').slideToggle('slow');
    });

    $('#main-slider .slides').each(function(){
      $(this).prepend('<div class="staple-overlay"></div>');
    });

    
    var mainHeaderHeight = $('#masthead').actual( 'outerHeight' );

    $(window).resize(function(){
    var headerHeight = $('#main-header').actual( 'outerHeight' );
    $('.staple-menu').css('line-height',headerHeight+'px');

    if($('#masthead').hasClass('classic') || $(window).width() < 1170){
      $('#main-slider .caption-wrapper').each(function(){
        var slideHeight = $(this).actual( 'outerHeight' );
        $(this).css('margin-top', -(slideHeight/2));
      });
    }else{
      $('#main-slider .caption-wrapper').each(function(){
        var slideHeight = $(this).actual( 'outerHeight' );
        $(this).css('margin-top', (mainHeaderHeight/2)-(slideHeight/2)-10);
      });
    }
    }).resize();
 
});

new WOW().init();