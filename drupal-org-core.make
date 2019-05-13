api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.7.1
;; Issue #2990664: Media library does not work when Drupal is installed into a sub-directory
projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-03-31/2990664-17-3044656-2.patch
;; Issue #2771361: Fix multiple ajax calls problem, which causes the browser to be in an infinite loop thus causing a crash.
;;projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-03-29/2771361-27.patch
;; Issue #3028821: Layout builder doesn't redirect properly to the translation.
;;projects[drupal][patch][] = https://www.drupal.org/files/issues/2019-01-28/layout_builder_redirect_language_fixed-3028821-5.patch
