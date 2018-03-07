/**
 * @file
 * Defines the behavior of the media entity browser view.
 */

(function ($) {

  "use strict";

  /**
   * Attaches the behavior of the media entity browser view.
   */
  Drupal.behaviors.seedsMedia = {
    attach: function (context, settings) {
      $('.view-media-browser .views-col').once().each(function () {
        var input = $(this).find('.views-field-entity-browser-select input');
        (input.prop('checked') === true) ? $(this).addClass('checked') : $(this).removeClass('checked');
      });

      $('.view-media-browser .views-col', context).click(function () {
        var input = $(this).find('.views-field-entity-browser-select input');
        input.prop('checked', !input.prop('checked'));
        $(this)[input.prop('checked') ? 'addClass' : 'removeClass']('checked');
      });
    }
  };

}(jQuery, Drupal));
