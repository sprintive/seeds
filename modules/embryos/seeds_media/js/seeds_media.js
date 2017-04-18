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
      $('.view-media-browser .views-col', context).once().click(function () {
        var $row = $(this);
        var $input = $row.find('.views-field-entity-browser-select input');
        $input.prop('checked', !$input.prop('checked'));
        $row[$input.prop('checked') ? 'addClass' : 'removeClass']('checked');
      });
    }
  };

}(jQuery, Drupal));
