<!-- @file Instructions for subtheming using the Sass Starterkit. -->
<!-- @defgroup sub_theming_sass -->
<!-- @ingroup sub_theming -->
# Seeds Leaves Sass Starterkit - Seeds leaves

Below are instructions on how to create a Bootstrap sub-theme using a Sass
preprocessor.

- [Prerequisites](#prerequisites)
- [Additional Setup](#setup)
- [Overrides](#overrides)

## Prerequisites
- Read the @link getting_started Getting Started @endlink and
  @link sub_theming Sub-theming @endlink documentation topics.
- You must understand the basic concept of using the [Sass] CSS pre-processor.
- You must use a **[local Sass compiler](https://www.google.com/search?q=sass+compiler)**.
- You must use the [Bootstrap Framework Source Files] ending in the `.scss`
  extension, not files ending in `.css`.

## Additional Setup {#setup}
Install the latest npm **[npm](https://www.npmjs.com/get-npm)**

In your theme folder run (npm install), this will install all the required packages and libraries for this startedkit (e.g. bootstrap, fontawesome ..)

All scss and js files are located in (`./THEMENAME/src`), to compile these files please run `gulp build` from your theme directory.

for development please run `gulp watch`, which will keep buidling the scss and js files as you change them, also this command will run the livereload to update the changes live on the browser. To use the livereload please install google chrome's livereload plugin **[livereload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)**


## Overrides {#overrides}
The `./THEMENAME/scss/_default-variables.scss` file is generally where you will
spend the majority of your time providing any default variables that should be
used by the [Bootstrap Framework] instead of its own.

The `./THEMENAME/scss/overrides.scss` file contains various Drupal overrides to
properly integrate with the [Bootstrap Framework]. It may contain a few
enhancements, feel free to edit this file as you see fit.

The `./THEMENAME/scss/style.scss` file is the glue that combines:
`_default-variables.scss`, [Bootstrap Framework Source Files] and the
`overrides.scss` file together. Generally, you will not need to modify this
file unless you need to add or remove files to be imported. This is the file
that you should compile to `./THEMENAME/css/style.css` (note the same file
name, using a different extension of course).

#### See also:
- @link theme_settings Theme Settings @endlink
- @link templates Templates @endlink
- @link plugins Plugin System @endlink

[Bootstrap Framework]: https://getbootstrap.com/docs/3.3/
[Bootstrap Framework Source Files]: https://github.com/twbs/bootstrap-sass
[Sass]: http://sass-lang.com
