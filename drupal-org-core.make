api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.6.9
;; Issue #2990664: Media library does not work when Drupal is installed into a sub-directory
projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-09-10/media-library-subfolder-installation-path-error-2990664-4-d8.patch
;; Issue #2771361: Fix multiple ajax calls problem, which causes the browser to be in an infinite loop thus causing a crash.
 projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-03-29/2771361-27.patch
