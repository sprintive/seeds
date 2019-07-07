/**
 * @file
 * Seeds Coat fixes.
 *
 */
(function ($, Drupal) {

	'use strict';

	Drupal.behaviors.seeds_coat = {
		attach: function (context, settings) {
			$(".tabs").once('seeds-coat-node-edit').click(function () {
				$(this).children(".nav-tabs.primary").slideToggle('slow', function () { });
			});
		}
	};

})(jQuery, Drupal);
