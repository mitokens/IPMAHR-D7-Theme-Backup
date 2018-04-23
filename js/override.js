/*
** Override addClass(), toggleClass(), and removeClass() to also cause an event trigger.
*/
(function() {
	/* Save the function for later. */
	var coreAddClass = jQuery.fn.addClass;
	/* Override the function. Call the saved function at the end. */
	jQuery.fn.addClass = function() {
		jQuery(this).trigger('changeClass', arguments);
		coreAddClass.apply(this, arguments);
	}
})();
