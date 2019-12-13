api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.8.0
;; Issue #2771361: Fix multiple ajax calls problem, which causes the browser to be in an infinite loop thus causing a crash.
projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-03-29/2771361-27.patch
;; Issue #2985168: Allow media items to be edited in a modal when using the field widget
projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-10-18/2985168-21.patch
;; Issue #3045171: Form blocks rendered inside layout builder break save
projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-08-01/drupal-layout_builder_unable_to_save-3045171-77.patch
