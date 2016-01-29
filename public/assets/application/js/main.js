$(document).ready(function(){
var austDay = new Date();
	austDay = new Date(austDay.getFullYear() , 1 - 1, 26);
	$('.timer').countdown({until: austDay});


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
	
});