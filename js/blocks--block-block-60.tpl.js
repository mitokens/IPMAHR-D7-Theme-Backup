/*
**
*/
jQuery(window).ready(function() {
	jQuery(window).bind('load resize',function() {
		var landing_item = jQuery('#block-block-60 .landing li.active-trail.expanded li.active-trail.expanded > ul');
		jQuery('#content-wrapper').css('margin-top',(landing_item.height()+2)+'px');
		//if(landing_item.attr("class")=="menu nav") {
			//landing_item.parents("#block-block-60").css("padding-bottom",landing_item.height()+"px");
		//}
	});
});
