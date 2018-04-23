/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
* This file is used/requested by the 'Styles' button.
* The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
* Format:
* {name:'', element:'', overrides:'', styles:{'':''}, attributes:{'':''}}
*/
if(typeof(CKEDITOR) !== 'undefined') {
	CKEDITOR.addStylesSet('drupal',
		[
			/* Block Styles */
			{name:'Unformatted', element:'div'},
			{name:'Paragraph', element:'p'},
			{name:'Heading', element:'h2'},
			{name:'Sub-Heading', element:'h3'},
			{name:'Mini-Heading', element:'h4'},
			{name:'Aside', element:'aside'},
			{name:'Blockquote', element:'blockquote'},
			/* Inline Styles */
			{name:'Button', element:'b'},
			{name:'Strong', element:'strong'},
			{name:'Emphasis', element:'em'},
			{name:'Small', element:'small'},
			{name:'Faded', element:'i'},
			{name:'Quotation', element:'q'},
			{name:'Citation', element:'cite'},
			/*{name:'Inserted', element:'ins'},*/
			/*{name:'Deleted', element:'del'},*/
		]
	);
}