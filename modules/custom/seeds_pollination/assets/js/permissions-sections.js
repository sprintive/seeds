(function ($, Drupal) {
  Drupal.behaviors.permissionsSections = {
    attach: function (context, settings) {
      var permissionsCopy = [];
      var currentSection = null;
      $(".permissions-section")
        .once("permissionsSections")
        .each(function () {
          var section = $(this);
          var checkedCount = $(".permissions-checked-count", section);

          // Collapse
          $(".permissions-header", this).on("click", function (e) {
            e.preventDefault();
            var removeVisible = $(".permissions-collapsable", section).hasClass(
              "visible"
            );
            $(".permissions-section .permissions-collapsable").removeClass(
              "visible"
            );
            if (removeVisible) {
              $(".permissions-collapsable", section).removeClass("visible");
            } else {
              $(".permissions-collapsable", section).addClass("visible");
            }
          });

          // Check all
          $(".permissions-check-all", this).on("click", function (e) {
            e.preventDefault();
            checkedCount.html(0);
            if (section.find(".permissions-collapsable").hasClass("visible")) {
              e.stopPropagation();
            }
            $('input[type="checkbox"]', section)
              .prop("checked", true)
              .trigger("change");
          });

          // Uncheck all
          $(".permissions-uncheck-all", this).on("click", function (e) {
            e.preventDefault();
            checkedCount.html(0);
            if (section.find(".permissions-collapsable").hasClass("visible")) {
              e.stopPropagation();
            }
            $('input[type="checkbox"]', section).prop("checked", false);
          });

          // Copy
          $(".permissions-copy", this).on("click", function (e) {
            e.preventDefault();
            permissionsCopy = [];
            var groupId = section.attr("data-group");
            if (section.find(".permissions-collapsable").hasClass("visible")) {
              e.stopPropagation();
            }
            $("input[data-copy]", section).each(function () {
              permissionsCopy.push($(this).prop("checked"));
            });

            $(".permissions-paste").attr("disabled", true);
            $(
              `.permissions-section[data-group='${groupId}'] .permissions-paste`
            ).attr("disabled", false);
          });

          // Paste
          $(".permissions-paste", this).on("click", function (e) {
            e.preventDefault();
            checkedCount.html(permissionsCopy.filter((p) => p == true).length);
            if (section.find(".permissions-collapsable").hasClass("visible")) {
              e.stopPropagation();
            }
            $("input[data-copy]", section).each(function (key) {
              $(this).prop("checked", permissionsCopy[key]);
            });
          });

          // Add a change event on checkboxes.
          $('input[type="checkbox"]', this).on("change", function () {
            if ($(this).prop("checked")) {
              checkedCount.html(parseInt(checkedCount.html()) + 1);
            } else {
              checkedCount.html(parseInt(checkedCount.html()) - 1);
            }
          });
        });
    },
  };
})(jQuery, Drupal);
