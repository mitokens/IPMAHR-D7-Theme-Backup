jQuery(window).ready(function() {
	jQuery(window).bind('load resize',function() {
		var slideshow = jQuery('#block-block-67 iframe');
		var slideshow_width;
		slideshow.css('width','100%');
		slideshow.css('height',(slideshow.width()*0.312+41)+'px');
	});
});