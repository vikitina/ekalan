$(document).ready(function(){
//var austDay = new Date();
	//austDay = new Date(austDay.getFullYear() , 1 - 1, 26);
	//$('.timer').countdown({until: austDay});


// external js: masonry.pkgd.js, imagesloaded.pkgd.js

// init Masonry
var $grid = $('.grid').masonry({
  itemSelector: '.grid-item',
  percentPosition: true,
  columnWidth: '.grid-sizer'
});
// layout Isotope after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.masonry();
});  


$('.navigation .open').on('mousedown', function(){

	$(this).removeClass('open');
	
});
console.log('---------------' + $(window).scrollTop());
 if ($(window).scrollTop() > 50) {
            $('header').addClass('sticky');
            $('.navigation').removeClass('wow').removeClass('fadeInDown').addClass('vis');
            $('.logo').removeClass('wow').removeClass('fadeInDown').addClass('vis');

           //  $('.promo_info').addClass('opened');
         }
});