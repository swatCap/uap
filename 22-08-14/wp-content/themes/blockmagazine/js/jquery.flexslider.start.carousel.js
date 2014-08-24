jQuery(window).load(function() {
/*global jQuery:false */
"use strict";
	
  jQuery('.flexcarousel').flexslider({
    animation: "slide",
    animationLoop: true,
    itemWidth: 183,        
	slideshowSpeed: 10000, 
    itemMargin:0,
    minItems: 1,
    maxItems: 4,
	smoothHeight: true
  });
  
	jQuery(document).ready(function () {
		jQuery(".flexcarousel").animate({height:'110'},800);
	});
  
});