(function($, Drupal) {
  Drupal.behaviors.seedsMediaLibrary = {
    attach: function(context, settings) {
      $(".edit-media")
        .once("seedsMediaLibrary")
        .on("click", function() {
          $(".selected-media").removeClass("selected-media");

          var mediaEntity = $(this)
            .parent()
            .find(".media-library-item__preview")
            .parent();
          mediaEntity.addClass("selected-media");
        });
    }
  };
})(jQuery, Drupal);
