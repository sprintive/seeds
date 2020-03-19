### Seeds: Kickoff distribution for SMEs

[![Latest Stable Version](https://poser.pugx.org/sprintive/seeds/v/stable)](https://packagist.org/packages/sprintive/seeds) [![Total Downloads](https://poser.pugx.org/sprintive/seeds/downloads)](https://packagist.org/packages/sprintive/seeds) [![Latest Unstable Version](https://poser.pugx.org/sprintive/seeds/v/unstable)](https://packagist.org/packages/sprintive/seeds) [![License](https://poser.pugx.org/sprintive/seeds/license)](https://packagist.org/packages/sprintive/seeds) [![composer.lock](https://poser.pugx.org/sprintive/seeds/composerlock)](https://packagist.org/packages/sprintive/seeds)

[![Seeds](https://www.drupal.org/files/styles/grid-3-2x/public/project-images/screenshot_375.png?itok=fCIrtWGf)](https://www.drupal.org/project/seeds)

Light distribution to kick off all projects regardless scale, you can use it to speed up your projects.

Seeds focusing on Arabic website with RTL interfaces so if you have any issue with your Arabic language website you are more than welcome to contribute with us.


#### Sponsored and developed by:

[![Sprintive](https://www.drupal.org/files/styles/grid-3/public/drupal_4.png?itok=FXajfgGW)](http://sprintive.com)

Sprintive is a web solution provider which transform ideas into realities, where humans are the center of everything, and Drupal is the heart of our actions, it has built and delivered Drupal projects focusing on a deep understanding of business goals and objective to help companies innovate and grow.

# Documentation
- [Creating a subtheme](#markdown-header-creating-a-subtheme)
- [Styling using sass](#markdown-header-styling-using-sass)
- [Enabling RTL styling](#markdown-header-enabling-rtl-styling)
- [Mixins you can use in sass](#markdown-header-mixins-you-can-use-in-sass)
- [Sass placeholder classes that you can extend](#markdown-header-sass-placeholder-classes-that-you-can-extend)
- [CKEditor RTL and LTR styling](#markdown-header-ckeditor-rtl-and-ltr-styling)
- [Using responsive font sizes in sass](#markdown-header-using-responsive-font-sizes-in-sass)
- [Disable bootstrap container in certian content types](#markdown-header-disable-bootstrap-container-in-certian-content-types)
- [Override blazy loader](#markdown-header-override-blazy-loader)
- [Set default medias](#markdown-header-set-default-medias)

## Creating a subtheme
Creating a subtheme is simple, you have to have a git init in your project, then by running the `create_subtheme.sh`and following the instructions, you would have a ready-to-go theme in your hands. Run:
```
./public_html/profiles/contrib/seeds/themes/custom/seeds_coat/scripts/create_subtheme.sh
```
You will be asked to enter you theme machine name and label, after that, the theme is created and activated automatically.

## Styling using sass
After you created your subtheme, it will automatically run `npm install`inside the subtheme folder, all you have to do is running:
```
gulp watch OR npm start
```
Then begin styling. After you are done, make sure to run:
```
gulp build OR npm run build
```
To build and minify the css when deploying to production.

There are certian settings you can modify in the `theme.json`:
```json
{
	"livereloadPort": 35729,
	"rtlEnabled": false
}
```

## Enabling RTL styling
In you `THEMENAME.theme`, find the following lines:
```
/* Comment out and change "THEMENAME" to enable rtl style */
// $variables['page']['#attached']['library'][] = 'THEMENAME/rtl';
```
Comment this out to enable RTL styling.
## Mixins you can use in sass
### @include form($gutter: 15px, $min-width: 180px);
This mixin defines general classes for forms:
- .form-2col
- .form-3col
- .form-4col

When you are creating a webform, you can create a container and then add one of the above to act as a row that contains form elements.
By default, it is added for all webforms.

### @include form-inline($gutter: 5px, $break: 767px);
Define an inline form with gutter and a maximum breakpoint.

### @include responsive-image-blazy($lg, $md, $sm);
Using it with the combination of `seeds_coat` responsive image styles, it can prove useful. This mixin is used when you want to use blazy with core responsive image styles
to avoid content reflows using `padding-top` check the `_mixin.scss` file for additonal info.

```sass
.node--type-article {
	@include responsive-image-blazy(
		('w':1200,'h':900),
		('w':900,'h':600),
		('w':400,'h':400)
	);
}

```
Where 'w' is the width of the image and 'h' is the height. The mixin uses three bootstrap breakpoints: `lg, md, sm`

### @include shadow();
Sets a shadowy container on the element. Useful with images.
### @include fontawesome($content, $psuedo: 'before');
Includes a fontawesome icon. See [Fontawesome v4](https://fontawesome.com/v4.7.0/)

```sass
@include fontawesome('\f2d1');
```

## Sass placeholder classes that you can extend
### @extend %center
Centers an element.
```sass
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
margin: auto;
```
### @extend %absolute-full
Set position to absolute and stretch it.
```sass
position: absolute;
top: 0;
left: 0;
right: 0;
bottom: 0;
```
## CKEditor RTL and LTR styling
Go to `/admin/config/content/seeds` or `Admin >> Configuration >> Content Authoring >> Seeds Content Settings`, You will see CKEditor styling settings. By default, it is initialized, but if you want to change it, feel free to do it.

## Using responsive font sizes in sass
in your `_theme-variables.scss` file, comment out this line:
```
// $enable-responsive-font-sizes: true
```
You can now use the bootstrap 4 build in mixin:
```sass
@include  rfs(64px);
// OR
@include  responsive-font-size(64px);
// OR
@include  font-size(64px);
```
## Disable bootstrap container in certian content types
Go to `/admin/structure/types`, Click edit on a content type. You will be met with various settings. At the bottom, you will see `Container settings`, Navigate there and enable `Fluid container` to disable the bootstrap container.

## Override blazy loader
Go to `/admin/config/seeds_media`. You will see blazy settings.  Check the `Override blazy loader?` then set the background image and color to something you like, hit save and flush the cache, you should see the loader takes a different appearence.
## Set default medias
We also provide a neat feature, you can set some default medias to not allow accidental edits by the client. Simply, go edit any media, you will see at the bottom a checkbox, `Default media`, check it and save, now only users with `Bypass Default Media Access` permission can edit the media.
