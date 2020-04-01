(function($, Drupal) {
  Drupal.behaviors.seedsMediaLibrary = {
    attach: function(context, settings) {
      $(".edit-media")
        .once("seedsMediaLibrary")
        .on("click", function() {
          $(".selected-media").removeClass("selected-media");

          var mediaEntity = $(this)
            .parent()
            .find("article[data-drupal-selector]")
            ;
          mediaEntity.addClass("selected-media");
        });
    }
  };
})(jQuery, Drupal);
