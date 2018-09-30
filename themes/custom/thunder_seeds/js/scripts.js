/**
 * @file Behaviors for the thunder_seeds module.
 */

(function ($, _, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.thunder_seeds = {
    attach: function (context, settings) {
      $(window).on("resize", function () {
        if ($(window).width() > 1199) {
          $('body').addClass('advanced-sidebar-tray-toggled');
        } else {
          $('body').removeClass('advanced-sidebar-tray-toggled');
        }
      }).resize();
    }
  }
})(window.jQuery, window._, window.Drupal, window.drupalSettings);