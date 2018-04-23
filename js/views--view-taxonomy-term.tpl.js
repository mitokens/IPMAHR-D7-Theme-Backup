
/*
** Hide the view's filter controls when the view has no results.
** Do not hide filters if they are being used.
*/
//jQuery(window).ready(function() {
//	"use strict";
//	var queryString = window.location.search;
//	if (!queryString || !(queryString.indexOf('maxdate') > -1 || queryString.indexOf('mindate') > -1 || queryString.indexOf('title') > -1 || queryString.indexOf('context') > -1)) {
//		jQuery('.view-taxonomy-term .view-empty').siblings('.view-filters').addClass("hide");
//		jQuery('.view-taxonomy-term .view-filters + .view-filters').siblings('.view-filters').addClass("hide");
//	}
//});

/*
** Hide the terms field if it only contains the currently active term of the view.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('.view-taxonomy-term .views-field-term-node-tid .active:only-of-type').parents('.views-field-term-node-tid').css('display','none');
});

/*
** Hide empty elements in each row's description, even if they contain a single &nbsp;
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('.view-taxonomy-term .views-field-body *').each(function() {
		var self = jQuery(this);
		var self_html = self.html();
		if (self_html == '&nbsp;') {
			self.css('display','none');
		}
	});
});
