/**
 * MAIN JAVASCRIPT FILE
 * Other javascript files concatenated via Gulp
 * User devvars.js and gulpvars.js files to modify Gulp variables
 */

(function($, global) {

	"use strict";

	var website = {

		init: function() {
			this.ui();
		},

		ui: function() {

			/* Smooth scrolling */
			$("a[href^='#']").smoothScroll();

		}

	};

	jQuery(document).ready(function($) {

		website.init();

	});

})(jQuery, window);