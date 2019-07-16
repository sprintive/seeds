#!/bin/bash
# Script to quickly create sub-theme.

error_message () {
    echo -e "\033[41m$1\033[0m\033[K"
}

# function to check that all requirements exist.
exit_if_error () {
    if [ ! $1 -eq 0 ]
    then
        error_message " There are errors or warnings detected in your code.\n \033[1mFix The errors then try to generate theme again.$3 "
		exit 1
    fi
}

echo '
+------------------------------------------------------------------------+
| With this script you could quickly create seeds_coat sub-theme     |
| In order to use this:                                              |
| - seeds_coat theme (this folder) should be in the contrib folder   |
+------------------------------------------------------------------------+
'

PROJECT_FOLDER="$(git rev-parse --show-toplevel)"; exit_if_error $?;
PROJECT_ROOT="$PROJECT_FOLDER/public_html";
SUBTHEME_DIRECTORY="$PROJECT_ROOT/profiles/contrib/seeds/themes/custom/seeds_coat/subtheme"
THEMES_DIRECTORY="$PROJECT_ROOT/themes";

# Get theme information.
echo 'The machine name of your custom theme? [e.g. hello_world]'
read CUSTOM_SEEDS_THEME

echo 'Your theme name ? [e.g. Hello World]'
read CUSTOM_SEEDS_THEME_NAME

# Check of themes folder exist. and create if not.
if [[ ! -e $PROJECT_ROOT/themes ]]; then
    mkdir $PROJECT_ROOT/themes
fi

# Copy subtheme to the themes folder.

cp -r $SUBTHEME_DIRECTORY $THEMES_DIRECTORY/$CUSTOM_SEEDS_THEME;
cd $THEMES_DIRECTORY/$CUSTOM_SEEDS_THEME;

for file in *THEMENAME.*; do mv $file ${file//THEMENAME/$CUSTOM_SEEDS_THEME}; done
for file in config/*/*THEMENAME*; do mv $file ${file//THEMENAME/$CUSTOM_SEEDS_THEME}; done

grep -Rl THEMENAME .|xargs sed -i '' -e "s/THEMENAME/$CUSTOM_SEEDS_THEME/"

cd $THEMES_DIRECTORY/$CUSTOM_SEEDS_THEME;
npm install
gulp build
drush en $CUSTOM_SEEDS_THEME -y
drush config-set system.theme default $CUSTOM_SEEDS_THEME -y
