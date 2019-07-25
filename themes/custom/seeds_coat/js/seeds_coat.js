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
			$(".tabs").once('seeds_coat').click(function () {
				$(this).children(".nav-tabs.primary").slideToggle('slow', function () { });
			});
			// Remove on click when clicking on contextual links.
			$(window).on('load', function () {
				$("*[onclick*='location.href'] div.contextual").on('click', function (event) {
					event.stopPropagation();
				});
			})
		}
	};

})(jQuery, Drupal);
