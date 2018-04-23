jQuery(window).ready(function() {
	"use strict";
	/*
	** turn PayPal transaction ID fields into clickable links
	*/
	jQuery('.field-name-field-paypal-id .field-item li').each(function() {
		var thisOne = jQuery(this);
		var oldText = thisOne.html();
		var newText = '<a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id='+oldText+'">'+oldText+'</a>';
		thisOne.html(newText);
	});
});