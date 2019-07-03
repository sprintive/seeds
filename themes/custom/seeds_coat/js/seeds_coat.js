/**
 * @file
 * Seeds Coat fixes.
 *
 */
(function ($, Drupal) {

	'use strict';

	Drupal.behaviors.seeds_coat = {
		attach: function (context, settings) {
			$(".tabs").click(function () {
				$(this).children(".nav-tabs.primary").slideToggle('slow', function () { });
			});
		}
	};

})(jQuery, Drupal);
