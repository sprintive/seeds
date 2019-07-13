api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.7.4
;; Issue #2990664: Media library does not work when Drupal is installed into a sub-directory
projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-06-11/2990664-36-a.patch
;; Issue #2771361: Fix multiple ajax calls problem, which causes the browser to be in an infinite loop thus causing a crash.
projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-03-29/2771361-27.patch
;; Issue #2985168: Allow media items to be edited in a modal when using the field widget
;;projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-05-06/2985168-11.patch
