# Project Setup

This guide outlines the necessary steps to set up and configure the WordPress environment along with additional plugins, themes, and dependencies.

## Prerequisites

-   [Node.js](https://nodejs.org/)
-   [Yarn](https://yarnpkg.com/)
-   [Gulp](https://gulpjs.com/)
-   [WP-CLI](https://wp-cli.org/)

## Theme Installation

```sh
# Install the theme
wp theme install https://github.com/kleytoncaires/inc-digital/archive/main.zip

# Rename the theme folder (replace 'theme-name' with the desired name)
mv wp-content/themes/inc-digital wp-content/themes/{theme}

# Activate the theme (replace 'theme-name' with the desired name)
wp theme activate {theme}

# Remove unnecessary files and themes
wp theme delete twentytwentytwo twentytwentythree twentytwentyfour
rm -rf wp-config-sample.php readme.html license.txt
```

## Set up language and timezone

```sh
# Install Portuguese (Brazil) language
wp language core install pt_BR

# Switch site language to Portuguese (Brazil)
wp site switch-language pt_BR

# Set timezone to 'America/Sao_Paulo'
wp option update timezone_string 'America/Sao_Paulo'
```

## Plugin Installation

```sh
# Install and activate plugins
wp plugin install contact-form-7 contact-form-cfdb7 wordpress-seo wp-mail-smtp wp-migrate-db --activate

# Install and activate ACF PRO
wp plugin install "https://connect.advancedcustomfields.com/v2/plugins/download?p=pro&k=b3JkZXJfaWQ9Nzg5MDd8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE2LTA0LTA1IDEzOjQwOjQw&_gl=1*hn0494*_gcl_au*MTM5NTY4MTA5My4xNzI1MzY4NDc5*_ga*MTU2NTI3MzM4OS4xNzI1MzY4NDc3*_ga_QQ5FN8NX8W*MTcyODUwMTA5Ni42LjEuMTcyODUwMTg3Ni41OS4wLjE2MTU0ODQ1MjA" --activate
```

## Create Homepage and Configure Front Page

```sh
# Create a homepage
wp post create --post_type=page --post_title='Home' --post_status=publish

# Set the front page to display a static page
wp option update show_on_front page

# Get the ID of the newly created page
wp post list --post_type=page --field=ID --home

# Update the page_on_front option with the ID of the homepage
# (Make sure to replace [ID] with the ID of the page obtained in the previous step)
wp option update page_on_front [ID]
```

## Run Project in VSCode

```sh
# Make sure to replace theme name
cd wp-content/themes/{theme}
code .
```

## Dependency Installation

```sh
# Install gulp dependencies using Yarn:
yarn

# Install project dependencies using Yarn:
yarn add jquery jquery-mask-plugin @fancyapps/ui swiper aos modern-normalize --save
```

## Task Execution

```sh
# Execute tasks using Yarn:
yarn start
```

## License & Attribution

MIT © [Kleyton Caires](https://linkedin.com/in/kleytoncaires).

This project is inspired by the work of many awesome developers especially those who contribute to this project, Gulp.js, Babel, and many other dependencies as listed in the `package.json` file. FOSS (Free & Open Source Software) for the win.
