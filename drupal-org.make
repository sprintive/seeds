core = 8.x
api = 2
defaults[projects][subdir] = contrib

projects[entity][type] = module
projects[entity][version] = 1.2

projects[entity_reference_revisions][type] = module
projects[entity_reference_revisions][version] = 1.8

projects[ctools][type] = module
projects[ctools][version] = 3.4

projects[token][type] = module
projects[token][version] = 1.9

projects[webform][type] = module
projects[webform][version] = 5.23

projects[ds][type] = module
projects[ds][version] = 3.9

projects[field_group][type] = module
projects[field_group][version] = 3.1

projects[linkit][type] = module
projects[linkit][version] = 5.0-beta12

projects[seeds_layouts][type] = module
projects[seeds_layouts][version] = 1.3

projects[crop][type] = module
projects[crop][version] = 2.1

projects[focal_point][type] = module
projects[focal_point][version] = 1.5
;; Issue #3094478: Integrate focal point with media_library
projects[focal_point][patch][] = https://www.drupal.org/files/issues/2020-01-09/3094478-10.patch

projects[smart_trim][type] = module
projects[smart_trim][version] = 1.3

projects[allowed_formats][type] = module
projects[allowed_formats][version] = 1.3

projects[paragraphs][type] = module
projects[paragraphs][version] = 1.12
;; Issue #2901390: Integrity constraint violation: 1048 Column 'langcode' cannot be null
projects[paragraphs][patch][] = https://www.drupal.org/files/issues/2019-08-10/paragraphs-set_langcode_widgets-290139_updated.patch

projects[slick][type] = module
projects[slick][version] = 2.2
;; Issues #3137067: Extra thumbnail after upgrade 8.x-2.1 >> 8.x-2.2
projects[slick][patch][] = https://www.drupal.org/files/issues/2020-06-07/extra_thumbnail-3137067-9.patch

projects[blazy][type] = module
projects[blazy][version] = 2.1

projects[slick_views][type] = module
projects[slick_views][version] = 2.3

projects[slick_paragraphs][type] = module
projects[slick_paragraphs][version] = 2.0

projects[photoswipe][type] = module
projects[photoswipe][version] = 2.9

projects[button_formatter][type] = module
projects[button_formatter][version] = 1.2

projects[layout_builder_restrictions][type] = module
projects[layout_builder_restrictions][version] = 2.8

projects[layout_builder_modal][type] = module
projects[layout_builder_modal][version] = 1.1

projects[shariff][type] = module
projects[shariff][version] = 1.7
;; Issue #3060551: data-url should be the url of the node.
projects[shariff][patch][] = https://www.drupal.org/files/issues/2019-06-10/shariff-node-data-url-3060551-3.patch

projects[admin_toolbar][type] = module
projects[admin_toolbar][version] = 2.4

projects[seeds_toolbar][type] = module
projects[seeds_toolbar][version] = 1.11

projects[media_embeddable][type] = module
projects[media_embeddable][version] = 1.0.0-beta2

projects[rabbit_hole][type] = module
projects[rabbit_hole][version] = 1.0-beta10

projects[menu_admin_per_menu][type] = module
projects[menu_admin_per_menu][version] = 1.3

projects[taxonomy_access_fix][type] = module
projects[taxonomy_access_fix][version] = 3.x-dev

projects[block_content_permissions][type] = module
projects[block_content_permissions][version] = 1.10
;; Issue #2920739: Allow accessing the Custom block library page without Administer blocks permission.
projects[block_content_permissions][patch][] = https://www.drupal.org/files/issues/2018-03-17/block_content_permissions-2920739-16.patch

projects[masquerade][type] = module
projects[masquerade][version] = 2.0-beta4

projects[responsive_preview][type] = module
projects[responsive_preview][version] = 1.0

projects[views_bulk_operations][type] = module
projects[views_bulk_operations][version] = 3.10

projects[views_bulk_edit][type] = module
projects[views_bulk_edit][version] = 2.5

projects[diff][type] = module
projects[diff][version] = 1.0

projects[embed][type] = module
projects[embed][version] = 1.4

projects[entity_embed][type] = module
projects[entity_embed][version] = 1.1

projects[editor_advanced_link][type] = module
projects[editor_advanced_link][version] = 1.8

projects[ace_editor][type] = module
projects[ace_editor][version] = 1.3

projects[ckeditor_bidi][type] = module
projects[ckeditor_bidi][version] = 2.1

projects[ckeditor_iframe][type] = module
projects[ckeditor_iframe][version] = 2.1

projects[fakeobjects][type] = module
projects[fakeobjects][version] = 1.1

projects[fast_404][type] = module
projects[fast_404][version] = 2.0-alpha5

projects[metatag][type] = module
projects[metatag][version] = 1.15

projects[pathauto][type] = module
projects[pathauto][version] = 1.8

projects[simple_sitemap][type] = module
projects[simple_sitemap][version] = 3.8

projects[link_attributes][type] = module
projects[link_attributes][version] = 1.11

projects[redirect][type] = module
projects[redirect][version] = 1.6

projects[google_analytics][type] = module
projects[google_analytics][version] = 2.5

projects[yoast_seo][type] = module
projects[yoast_seo][version] = 1.7

projects[length_indicator][type] = module
projects[length_indicator][version] = 1.1

projects[imageapi_optimize][type] = module
projects[imageapi_optimize][version] = 2.0-beta1

projects[imageapi_optimize_resmushit][type] = module
projects[imageapi_optimize_resmushit][version] = 1.0-beta1

projects[cloudflare][type] = module
projects[cloudflare][version] = 1.0-beta2

projects[ultimate_cron][type] = module
projects[ultimate_cron][version] = 2.0-alpha5

projects[smtp][type] = module
projects[smtp][version] = 1.0

projects[captcha][type] = module
projects[captcha][version] = 1.1

projects[recaptcha][type] = module
projects[recaptcha][version] = 2.5
;; Issue #2493183: Ajax support / Use behaviors for 2.x
projects[recaptcha][patch][] = https://www.drupal.org/files/issues/2020-01-30/recaptcha-ajax-2493183-197_0.patch
;; Issue #3035883: CAPTCHA validation error: unknown CAPTCHA session ID
projects[recaptcha][patch][] = https://www.drupal.org/files/issues/2019-11-15/3035883-29-workaround.patch

projects[password_policy][type] = module
projects[password_policy][version] = 3.0-beta1

projects[username_enumeration_prevention][type] = module
projects[username_enumeration_prevention][version] = 1.1

projects[events_log_track][type] = module
projects[events_log_track][version] = 1.1

projects[mass_pwreset][type] = module
projects[mass_pwreset][version] = 1.0-alpha5

projects[restrict_by_ip][type] = module
projects[restrict_by_ip][version] = 4.x-dev

projects[login_security][type] = module
projects[login_security][version] = 1.5

projects[bootstrap_barrio][type] = theme
projects[bootstrap_barrio][version] = 4.33

projects[seeds_coat][type] = theme
projects[seeds_coat][version] = 1.3

projects[root][type] = theme
projects[root][version] = 1.6


; Libraries
libraries[slick][download][type] = get
libraries[slick][download][url] = "https://github.com/kenwheeler/slick/archive/1.6.0.tar.gz"
libraries[slick][destination] = "libraries"

libraries[easing][download][type] = get
libraries[easing][download][url] = "https://github.com/gdsmith/jquery.easing/archive/1.4.1.tar.gz"
libraries[easing][destination] = "libraries"

libraries[blazy][download][type] = get
libraries[blazy][download][url] = "https://github.com/dinbror/blazy/archive/1.8.2.tar.gz"
libraries[blazy][destination] = "libraries"
