api = 2
core = 7.x

;;;;;;;;;;;;;;;;;;;;;
;; Utilities Modules
;;;;;;;;;;;;;;;;;;;;;

projects[ctools][version] = 1.12
projects[ctools][subdir] = utilities

projects[panels][version] = 3.9
projects[panels][subdir] = utilities

projects[jquery_update][version] = 3.0-alpha5
projects[jquery_update][subdir] = utilities

projects[views][version] = 3.18
projects[views][subdir] = utilities

projects[token][version] = 1.7
projects[token][subdir] = utilities

projects[libraries][version] = 2.3
projects[libraries][subdir] = utilities

projects[entity][version] = 1.8
projects[entity][subdir] = utilities

projects[file_entity][version] = 2.4
projects[file_entity][subdir] = utilities

projects[variable][version] = 2.5
projects[variable][subdir] = utilities

projects[entitycache][version] = 1.5
projects[entitycache][subdir] = utilities


;;;;;;;;;;;;;;;;;;;;;
;; Bundling Modules
;;;;;;;;;;;;;;;;;;;;;

projects[features][version] = 2.10
projects[features][subdir] = bundling

projects[strongarm][version] = 2.0
projects[strongarm][subdir] = bundling

projects[defaultconfig][version] = 1.0-alpha11
projects[defaultconfig][subdir] = bundling

;;;;;;;;;;;;;;;;;;;;;
;; UI Modules
;;;;;;;;;;;;;;;;;;;;;

projects[ds][version] = 2.14
projects[ds][subdir] = utilities

projects[flexslider][version] = 2.0-rc2
projects[flexslider][subdir] = ui

projects[ds_bootstrap_layouts][version] = 3.1
projects[ds_bootstrap_layouts][subdir] = ui

projects[fitvids][version] = 1.17
projects[fitvids][subdir] = ui

;;;;;;;;;;;;;;;;;;;;;
;; SEO Modules
;;;;;;;;;;;;;;;;;;;;;

projects[google_analytics][version] = 2.3
projects[google_analytics][subdir] = seo

projects[imagecache_token][version] = 1.0-rc2
projects[imagecache_token][subdir] = seo

projects[metatag][version] = 1.22
projects[metatag][subdir] = seo

projects[pathauto][version] = 1.3
projects[pathauto][subdir] = seo

projects[redirect][version] = 1.0-rc3
projects[redirect][subdir] = seo

projects[transliteration][version] = 3.2
projects[transliteration][subdir] = seo

projects[xmlsitemap][version] = 2.3
projects[xmlsitemap][subdir] = seo

;;;;;;;;;;;;;;;;;;;;;
;; Administration Modules
;;;;;;;;;;;;;;;;;;;;;

projects[admin_menu][version] = 3.0-rc5
projects[admin_menu][subdir] = administration
projects[admin_menu][patch][1910546] = "https://www.drupal.org/files/issues/sub_lists_not_show_on_rtl-1910546-1.patch"

projects[adminimal_admin_menu][version] = 1.7
projects[adminimal_admin_menu][subdir] = administration

projects[date_popup_authored][version] = 1.2
projects[date_popup_authored][subdir] = administration

projects[diff][version] = 3.3
projects[diff][subdir] = administration

projects[save_draft][version] = 1.4
projects[save_draft][subdir] = administration

projects[better_formats][version] = 1.0-beta2
projects[better_formats][subdir] = administration

projects[admin_views][version] = 1.6
projects[admin_views][subdir] = administration

projects[views_bulk_operations][version] = 3.4
projects[views_bulk_operations][subdir] = administration

;;;;;;;;;;;;;;;;;;;;;
;; WYSIWYG Modules
;;;;;;;;;;;;;;;;;;;;;

projects[media][subdir] = editor
projects[media][version] = "3.0-beta6"

projects[ckeditor][version] = 1.18
projects[ckeditor][subdir] = editor

projects[media_ckeditor][version] = "2.5"
projects[media_ckeditor][subdir] = editor

projects[pathologic][version] = 3.1
projects[pathologic][subdir] = editor

projects[token_filter][version] = 1.1
projects[token_filter][subdir] = editor

projects[wysiwyg_filter][version] = 1.6-rc3
projects[wysiwyg_filter][subdir] = editor

;;;;;;;;;;;;;;;;;;;;;
;; Fields Modules
;;;;;;;;;;;;;;;;;;;;;

projects[date][version] = 2.10
projects[date][subdir] = fields

projects[link][version] = 1.4
projects[link][subdir] = fields

projects[field_group][version] = 1.5
projects[field_group][subdir] = fields

projects[linkit][version] = 3.5
projects[linkit][subdir] = fields

projects[focal_point][version] = 1.0
projects[focal_point][subdir] = fields

projects[hires_images][version] = 1.1
projects[hires_images][subdir] = fields

projects[smart_trim][version] = 1.5
projects[smart_trim][subdir] = fields

projects[extlink][version] = 1.18
projects[extlink][subdir] = fields

;;;;;;;;;;;;;;;;;;;;;
;; Contrib Modules.
;; Modules used in sapling features but necessary in all projects.
;;;;;;;;;;;;;;;;;;;;;

projects[rabbit_hole][version] = 2.24
projects[rabbit_hole][subdir] = contrib

projects[fieldable_panels_panes][version] = 1.11
projects[fieldable_panels_panes][subdir] = contrib

projects[panelizer][version] = "3.4"
projects[panelizer][subdir] = contrib

projects[module_filter][version] = 2.1
projects[module_filter][subdir] = contrib

projects[copyprevention][version] = 1.1
projects[copyprevention][subdir] = contrib

projects[autocomplete_deluxe][version] = 2.3
projects[autocomplete_deluxe][subdir] = contrib

projects[webform][version] = 4.15
projects[webform][subdir] = contrib

projects[owlcarousel][version] = 2.x-dev
projects[owlcarousel][subdir] = contrib
projects[owlcarousel][patch][2736713] = "https://www.drupal.org/files/issues/rtl_support_carousel_2-2736713-6.patch"

projects[slick][version] = 2.0
projects[slick][subdir] = contrib
projects[slick][patch][2764893] = "https://www.drupal.org/files/issues/_slick_error-after-d750_2764893_9.patch"

projects[slick_views][version] = 2.0
projects[slick_views][subdir] = contrib

projects[photoswipe][version] = 2.0-beta3
projects[photoswipe][subdir] = contrib

projects[menu_attributes][version] = 1.0
projects[menu_attributes][subdir] = contrib

projects[media_oembed][version] = 2.7
projects[media_oembed][subdir] = contrib

;;;;;;;;;;;;;;;;;;;;;
;; Admin theme
;;;;;;;;;;;;;;;;;;;;;

projects[adminimal_theme][type] = theme
projects[adminimal_theme][version] = 1.24
projects[adminimal_theme][subdir] = contrib

;;;;;;;;;;;;;;;;;;;;;
;; Themes
;;;;;;;;;;;;;;;;;;;;;

projects[bootstrap][type] = theme
projects[bootstrap][version] = 3.14
projects[bootstrap][subdir] = contrib

;;;;;;;;;;;;;;;;;;;;;
;; Libraries
;;;;;;;;;;;;;;;;;;;;;


libraries[flexslider][download][type] = "get"
libraries[flexslider][download][url] = "http://github.com/woothemes/FlexSlider/archive/version/2.2.2.tar.gz"

libraries[slick][download][type] = "get"
libraries[slick][download][url] = "https://github.com/kenwheeler/slick/archive/master.zip"

libraries[easing][download][type] = "get"
libraries[easing][download][url] = "https://github.com/gdsmith/jquery.easing/archive/master.zip"

libraries[fitvids][download][type] = "get"
libraries[fitvids][download][url] = "https://raw.githubusercontent.com/davatron5000/FitVids.js/master/jquery.fitvids.js"

libraries[ckeditor][download][type] = "get"
libraries[ckeditor][download][url] = "http://download.cksource.com/CKEditor/CKEditor/CKEditor%204.2.2/ckeditor_4.2.2_standard.tar.gz"
