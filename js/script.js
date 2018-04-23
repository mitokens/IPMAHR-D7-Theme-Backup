
/*
** lower the HTML document by the height of the #navbar-administration element.
*/
jQuery('body.navbar-administration').ready(function() {
	"use strict";
	var navbarheight = jQuery('#navbar-administration > #navbar-bar').height();
	jQuery('html').css('top', navbarheight);
// 	jQuery('#navbar-administration > div').on('load resize', function() {
// 		var navheight = 0, navs = jQuery('#navbar-administration > div');
// 		for (var i = 0; i < navs.length; i += 1) {
// 			navheight += navs[i].height();
// 		}
// 		jQuery('html').css('top', navheight);
// 	});
});


/*
** Add an explicit "closed" attribute to <details>.
** This is a fallback for unsupported browsers.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('details[closed]').prop('closed', true).removeAttr('open');
	jQuery('details:not([closed]):not([open])').prop('closed', true).attr('closed', '');
	jQuery('details:not([closed])').prop('closed', false);
	jQuery('details').on('click', 'summary', function() {
		var thisSummary = jQuery(this);
		var thisDetails = thisSummary.closest('details');
		var thisDetailsStatus = thisDetails.prop('closed');
		if (thisDetailsStatus === true) {
			thisDetails.prop('closed', false).removeAttr('closed');
		}
		else /*if (thisDetailsStatus === false)*/ {
			thisDetails.prop('closed', true).attr('closed', '');
		}
	});
});


/*
** Set the tooltip title of every untitled anchor tag to its name and/or destination.
*/
//jQuery(window).ready(function() {
//	"use strict";
//	jQuery(':not(meta):not([title])[href], :not(meta):not([title])[name]').each(function() {
//		var hoc = jQuery(this);
//		var theTitle = '';
//		if (hoc.attr('name') && hoc.attr('href')) { theTitle = hoc.attr('name')+' » '+hoc.attr('href'); }
//		else if (hoc.attr('name')) { theTitle = hoc.attr('name'); }
//		else if (hoc.attr('href')) { theTitle = hoc.attr('href'); }
//		hoc.attr('title',theTitle);
//	});
//});


/*
** Remove dropdown menus from the sidebars.
*/
jQuery(window).ready(function() {
	"use strict";
	if (jQuery('.sidebar')) {
		jQuery('.sidebar .menu a').removeAttr('data-toggle').removeClass('dropdown-toggle');
		jQuery('.sidebar .menu li').removeClass('dropdown-submenu');
		jQuery('.sidebar .menu ul').removeClass('dropdown-menu');
	}
});


/*
** Add collapsing functionality to foldable elements.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('.foldable .folder').each(function() {
		var hoc = jQuery(this);
		hoc.on('click',function() {
			hoc.closest('.foldable').toggleClass('closed');
		});
	});
});


/*
** Add datepicker functionality to elements that need it.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('.node-product-test input#edit-attributes-24').datepicker();
});


/*
** Hide the <input> from radio elements with <code> in the <label>.
** Used on webform nodes.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery('.form-radios>.form-item>.option>code').parents('.form-item').children('input').remove();
});


/*
** Log a console message whenever the events feed block changes class.
** Requires a 'changeClass' trigger, whoch doesn't exist yet.
*/
//jQuery(window).ready(function() {
//	"use strict";
//	jQuery('#block-views-events-block-1').on('changeClass', function() {
//		console.log('#block-views-events-block-1 got class!');
//	});
//});


/*
** Hide taxonomy term labels when on that term's overview listing
*/
jQuery(window).ready(function() {
	"use strict";
	var tidClass = jQuery('.views-field-term-node-tid').first().attr('class');
	if (tidClass) {
		tidClass = tidClass.substring(tidClass.search('tid-'));
		jQuery('.'+tidClass+'>a>.'+tidClass).parent().hide();
	}
});


/*
** Keep the homepage slider at a stable height.
*/
jQuery(window).ready(function() {
	"use strict";
	jQuery(window).on('load resize',function() {
		var slider = jQuery('.view-home-page-slider');
		if (slider) {
			var slides = jQuery('.view-home-page-slider .views_slideshow_slide img');
			if (jQuery(window).width() >= 512) {
				slides = jQuery('.view-home-page-slider .views_slideshow_slide');
			}
			var maxSlideHeight = 0;
			for (var i = 0; i < slides.length; i+=1) {
				if (jQuery(slides[i]).height() > maxSlideHeight) {
					maxSlideHeight = jQuery(slides[i]).height();
				}
			}
			jQuery('.view-home-page-slider .views-slideshow-cycle-main-frame').attr('style','height:'+maxSlideHeight+'px!important;');
		}
	});
});


/*
** Converts the HTML element of a jQuery Object into a YouTube Player
** Requires YouTube iframe API <script src="https://www.youtube.com/iframe_api"></script>
** @param {jQuery} vid - The HTML element to replace with a YouTube Player
** @param {Number} [attempt=1] - The number of attempts
** @return {Player|undefined} The YouTube Player that was generated, or undefined
*/
function readyYoutubePlayer(vid, attempt) {
	attempt = (typeof attempt === 'number')? (attempt+1): (1);
	// make sure the YouTube API has loaded
	if (YT && YT.Player) {
		// get all of the video element's pertinent attributes
		var vid_id = vid.attr('id');
		var vid_src = (vid.attr('src'))? (vid.attr('src')): (vid_id);
		var vid_height = (vid.attr('height'))? (vid.attr('height')): (400);
		var vid_width = (vid.attr('width'))? (vid.attr('width')): (600);
		// if the src is a full YouTube URL, trim it down to just the videoId token
		vid_src = (vid_src.indexOf('youtube.com/watch') > -1)? (vid_src.substring(vid_src.indexOf('v=')+2)): (vid_src);
		vid_src = (vid_src.indexOf('youtube.com/embed') > -1)? (vid_src.substring(vid_src.indexOf('embed/')+6)): (vid_src);
		vid_src = (vid_src.indexOf('?') > -1)? (vid_src.substring(0, vid_src.indexOf('?'))): (vid_src);
		vid_src = (vid_src.indexOf('&') > -1)? (vid_src.substring(0, vid_src.indexOf('&'))): (vid_src);
		// YT.Player() requires the video element to have an ID set
		if (!vid_id && vid_src) {
			vid.attr('id', vid_src);
			vid_id = vid_src;
		}
		else if (!vid_id) {
			// should probably return an error message instead of 'undefined'
			return;
		}
		// create the YouTube Player element, the API will take care of inserting it into the DOM
		var player = new YT.Player(vid_id, {
			height: vid_height,
			width: vid_width,
			videoId: vid_src
		});
		return player;
	}
	// if no YouTube API, retry every second for upto 30 attempts
	else if (attempt < 30) {
		setTimeout(readyYoutubePlayer, 1000, vid, attempt);
	}
	// should probably return an error message instead of 'undefined'
	return;
}

/*
** Convert each <video> into YouTube embedded <iframe>
** Uses function readyYoutubePlayer
*/
jQuery(window).ready(function() {
	"use strict";
	var videos = jQuery.merge(jQuery('video.youtube'), jQuery('video[src*="youtube"]'));
	videos.each(function() {
		var hoc = jQuery(this);
		readyYoutubePlayer(hoc);
	});
});

