api = 2
core = 8.x
projects[drupal][type] = core
projects[drupal][version] = 8.6.3
;; Issue #2990664: Media library does not work when Drupal is installed into a sub-directory
projects[drupal][patch][] = https://www.drupal.org/files/issues/2018-09-10/media-library-subfolder-installation-path-error-2990664-4-d8.patch
