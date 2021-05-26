api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.9.15
;; Issue #2771361: Fix multiple ajax calls problem, which causes the browser to be in an infinite loop thus causing a crash.
projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-03-29/2771361-27.patch
;; Issue #2985168: Allow media items to be edited in a modal when using the field widget
projects[drupal][patch][] = https://www.drupal.org/files/issues/2021-05-17/drupal-n2985168-69-89x.patch
;; Issue #2958588: Off-canvas style resets are overriding styles (especially SVGs) in Safari, Firefox and Chromium Edge resulting in display issues
projects[drupal][patch][] = https://www.drupal.org/files/issues/2021-01-06/off-canvas-style-resets-2958588-13.patch
