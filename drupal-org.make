core = 8.x
api = 2
defaults[projects][subdir] = contrib

; Utilities Modules
projects[ctools][type] = module
projects[ctools][version] = 3.2

projects[token][type] = module
projects[token][version] = 1.5

projects[diff][type] = module
projects[diff][version] = 1.0-rc2


; Content Management Modules.
projects[ds][type] = module
projects[ds][version] = 3.3
;; Issue #2883928: Use absolute or external URL for link wrappers
projects[ds][patch][] = https://www.drupal.org/files/issues/2018-05-03/use_absolute_or-2883928-9.patch

projects[page_manager][type] = module
projects[page_manager][version] = 4.0-beta3

projects[panels][type] = module
projects[panels][version] = 4.4

projects[bootstrap_layouts][type] = module
projects[bootstrap_layouts][version] = 5.1
;; Issue #3018633: Incompatible with Layout builder drag and drop
projects[bootstrap_layouts][patch][] = https://www.drupal.org/files/issues/2018-12-06/3018633-draggable.patch
;; Issue #3010952: Add a container option
projects[bootstrap_layouts][patch][] = https://www.drupal.org/files/issues/2018-11-21/3010952-bootstrap-container-3.patch

projects[entity][type] = module
projects[entity][version] = 1.0-rc2

projects[entity_browser][type] = module
projects[entity_browser][version] = 2.1

projects[entity_embed][type] = module
projects[entity_embed][version] = 1.0-beta3

projects[embed][type] = module
projects[embed][version] = 1.0

projects[inline_entity_form][type] = module
projects[inline_entity_form][version] = 1.0-rc1

projects[media_entity_actions][type] = module
projects[media_entity_actions][version] = 1.0-alpha2

projects[media_entity_generic][type] = module
projects[media_entity_generic][version] = 1.0

projects[media_entity_image_exif][type] = module
projects[media_entity_image_exif][version] = 1.x-dev

projects[video_embed_field][type] = module
projects[video_embed_field][version] = 2.0

projects[crop][type] = module
projects[crop][version] = 1.5

projects[focal_point][type] = module
projects[focal_point][version] = 1.0

projects[smart_trim][type] = module
projects[smart_trim][version] = 1.1

projects[allowed_formats][type] = module
projects[allowed_formats][version] = 1.1

projects[slick][type] = module
projects[slick][version] = 1.1

projects[blazy][type] = module
projects[blazy][version] = 1.0-rc4

projects[slick_views][type] = module
projects[slick_views][version] = 1.0

projects[slick_media][type] = module
projects[slick_media][version] = 2.0-alpha3

projects[entity_reference_revisions][type] = module
projects[entity_reference_revisions][version] = 1.6

projects[paragraphs][type] = module
projects[paragraphs][version] = 1.8

projects[editor_advanced_link][type] = module
projects[editor_advanced_link][version] = 1.4

projects[contribute][type] = module
projects[contribute][version] = 1.0-beta7

projects[webform][type] = module
projects[webform][version] = 5.2

projects[rabbit_hole][type] = module
projects[rabbit_hole][version] = 1.0-beta6

projects[field_group][type] = module
projects[field_group][version] = 1.0

projects[photoswipe][type] = module
projects[photoswipe][version] = 2.9

projects[smtp][type] = module
projects[smtp][version] = 1.0-beta4

projects[field_formatter][type] = module
projects[field_formatter][version] = 1.2

projects[layout_builder_restrictions][type] = module
projects[layout_builder_restrictions][version] = 1.5

projects[linkit][type] = module
projects[linkit][version] = 5.0-beta8

; Performance & SEO Modules
projects[fast_404][type] = module
projects[fast_404][version] = 1.0-alpha4

projects[metatag][type] = module
projects[metatag][version] = 1.8

projects[pathauto][type] = module
projects[pathauto][version] = 1.4

projects[simple_sitemap][type] = module
projects[simple_sitemap][version] = 2.12

projects[link_attributes][type] = module
projects[link_attributes][version] = 1.6
;; Issue #2920269: Add title attribute
projects[link_attributes][patch][] = https://www.drupal.org/files/issues/2018-06-05/link_attributes-title-attribute-2920269-5.patch

projects[redirect][type] = module
projects[redirect][version] = 1.3

projects[google_analytics][type] = module
projects[google_analytics][version] = 2.4

projects[yoast_seo][type] = module
projects[yoast_seo][version] = 2.0-alpha3

; Security Modules
projects[honeypot][type] = module
projects[honeypot][version] = 1.29

projects[security_review][type] = module
projects[security_review][download][url] = https://git.drupal.org/project/security_review.git
projects[security_review][download][revision] = 9b8a34a21cac85913845df4eebb9a05c69de82d8
projects[security_review][download][branch] = 8.x-1.x

projects[cloudflare][type] = module
projects[cloudflare][version] = 1.0-alpha11

; Administration Modules.
projects[adminimal_admin_toolbar][type] = module
projects[adminimal_admin_toolbar][version] = 1.9

projects[admin_toolbar][type] = module
projects[admin_toolbar][version] = 1.26

projects[toolbar_anti_flicker][type] = module
projects[toolbar_anti_flicker][version] = 2.7

projects[menu_admin_per_menu][type] = module
projects[menu_admin_per_menu][version] = 1.0

projects[taxonomy_access_fix][type] = module
projects[taxonomy_access_fix][version] = 2.6

projects[block_content_permissions][type] = module
projects[block_content_permissions][version] = 1.6
;; Issue #2920739: Allow accessing the Custom block library page without Administer blocks permission
projects[block_content_permissions][patch][] = https://www.drupal.org/files/issues/2018-03-17/block_content_permissions-2920739-16.patch

projects[responsive_preview][type] = module
projects[responsive_preview][version] = 1.0-alpha7

projects[views_bulk_operations][type] = module
projects[views_bulk_operations][version] = 2.5

projects[views_bulk_edit][type] = module
projects[views_bulk_edit][version] = 2.2

projects[masquerade][type] = module
projects[masquerade][version] = 2.0-beta2

projects[seeds_toolbar][type] = module
projects[seeds_toolbar][version] = 1.0

; Themes
projects[bootstrap][type] = theme
projects[bootstrap][version] = 3.19

projects[thunder_admin][type] = theme
projects[thunder_admin][version] = 2.7

projects[root][type] = theme
projects[root][version] = 1.0

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

