(function ($) {
  let initialized = false;
  "use strict";

  /**
   * Attaches the behavior of the media entity browser view.
   */

  function bindButtonClick(context) {

    if ($(context).is('form')) {
      return;
    }

    $('.views-view-grid .views-col', $(context)).click(function () {
      var input = $(this).find('.views-field-entity-browser-select input');
      input.prop('checked', !input.prop('checked'));
      $(this)[input.prop('checked') ? 'addClass' : 'removeClass']('checked');
    });
  }

  Drupal.behaviors.seedsEntityBrowser = {
    attach: function (context, settings) {
      bindButtonClick(context);
    }
  };

}(jQuery, Drupal));
