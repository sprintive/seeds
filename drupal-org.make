core = 8.x
api = 2
defaults[projects][subdir] = contrib

; Utilities Modules
projects[ctools][type] = module
projects[ctools][version] = 3.0

projects[token][type] = module
projects[token][version] = 1.0


; Content Management Modules.
projects[ds][type] = module
projects[ds][version] = 3.1
projects[ds][patch][] = https://www.drupal.org/files/issues/url_link_fix-2883928-5.patch

projects[page_manager][type] = module
projects[page_manager][version] = 4.0-beta2

projects[panels][type] = module
projects[panels][version] = 4.2

projects[bootstrap_layouts][type] = module
projects[bootstrap_layouts][version] = 5.0-alpha1

projects[entity][type] = module
projects[entity][version] = 1.0-beta1

projects[entity_browser][type] = module
projects[entity_browser][version] = 1.3

projects[entity_embed][type] = module
projects[entity_embed][version] = 1.0-beta2

projects[embed][type] = module
projects[embed][version] = 1.0

projects[inline_entity_form][type] = module
projects[inline_entity_form][version] = 1.0-beta1

projects[media_entity][type] = module
projects[media_entity][version] = 1.6

projects[media_entity_image][type] = module
projects[media_entity_image][version] = 1.2

projects[media_entity_document][type] = module
projects[media_entity_document][version] = 1.1

projects[video_embed_field][type] = module
projects[video_embed_field][version] = 1.5

projects[focal_point][type] = module
projects[focal_point][version] = 1.0-beta4

projects[smart_trim][type] = module
projects[smart_trim][version] = 1.0

projects[allowed_formats][type] = module
projects[allowed_formats][version] = 1.1

projects[slick][type] = module
projects[slick][version] = 1.0

projects[blazy][type] = module
projects[blazy][version] = 1.0-rc2

projects[slick_views][type] = module
projects[slick_views][version] = 1.0-rc2

projects[slick_media][type] = module
projects[slick_media][version] = 1.0

projects[entity_reference_revisions][type] = module
projects[entity_reference_revisions][version] = 1.3

projects[paragraphs][type] = module
projects[paragraphs][version] = 1.2

projects[editor_advanced_link][type] = module
projects[editor_advanced_link][version] = 1.4

projects[webform][type] = module
projects[webform][version] = 5.0-beta18

projects[rabbit_hole][type] = module
projects[rabbit_hole][version] = 1.0-beta3

projects[field_group][type] = module
projects[field_group][version] = 1.0-rc6

projects[photoswipe][type] = module
projects[photoswipe][version] = 1.0-beta3
projects[photoswipe][patch][] = https://www.drupal.org/files/issues/aspect_ratio_incorrect-2695191-7.patch


; Performance & SEO Modules
projects[fast_404][type] = module
projects[fast_404][version] = 1.0-alpha2

projects[metatag][type] = module
projects[metatag][version] = 1.2

projects[pathauto][type] = module
projects[pathauto][version] = 1.0

projects[simple_sitemap][type] = module
projects[simple_sitemap][version] = 2.10

projects[link_attributes][type] = module
projects[link_attributes][version] = 1.1

projects[redirect][type] = module
projects[redirect][version] = 1.0-beta1

projects[google_analytics][type] = module
projects[google_analytics][version] = 2.2


; Security Modules
projects[honeypot][type] = module
projects[honeypot][version] = 1.27

; Administration Modules.
projects[adminimal_admin_toolbar][type] = module
projects[adminimal_admin_toolbar][version] = 1.5

projects[admin_toolbar][type] = module
projects[admin_toolbar][download][type] = git
projects[admin_toolbar][download][url] = "https://git.drupal.org/project/admin_toolbar.git"
projects[admin_toolbar][download][revision] = fa374ffa4339f8fde91e658f43ccf975604198c5


; Themes
projects[bootstrap][type] = theme
projects[bootstrap][version] = 3.6

projects[adminimal_theme][type] = theme
projects[adminimal_theme][version] = 1.3

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
