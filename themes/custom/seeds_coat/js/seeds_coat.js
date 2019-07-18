/**
 * @file
 * Seeds Coat fixes.
 *
 */
(function ($, Drupal) {

	'use strict';

	Drupal.behaviors.seeds_coat = {
		attach: function (context, settings) {
			// Node edit tab.
			$(".tabs").once('seeds-coat-node-edit').click(function () {
				$(this).children(".nav-tabs.primary").slideToggle('slow', function () { });
			});
			// Remove on click when clicking on contextual links.
			$("*[onclick*='location.href'] div.contextual").on('click', function (event) {
				event.stopPropagation();
			});
		}
	};

})(jQuery, Drupal);
