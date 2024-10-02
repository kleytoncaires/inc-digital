# Project Setup

This guide outlines the necessary steps to set up and configure the WordPress environment along with additional plugins, themes, and dependencies.

## Prerequisites

-   [Node.js](https://nodejs.org/)
-   [Yarn](https://yarnpkg.com/)
-   [Gulp](https://gulpjs.com/)
-   [WP-CLI](https://wp-cli.org/)

## Plugin Installation

````sh
# Install and activate plugins
wp plugin install contact-form-7 contact-form-cfdb7 wordpress-seo wp-mail-smtp wp-migrate-db --activate

## Cleanup
```sh
# Remove unnecessary files and themes
wp theme delete twentytwentytwo twentytwentythree twentytwentyfour
rm -rf wp-config-sample.php readme.html license.txt
````

## Set up language and timezone

```sh
# Install Portuguese (Brazil) language
wp language core install pt_BR

# Switch site language to Portuguese (Brazil)
wp site switch-language pt_BR

# Set timezone to 'America/Sao_Paulo'
wp option update timezone_string 'America/Sao_Paulo'
```

## Dependency Installation

```sh
# Install gulp dependencies using Yarn:
yarn

# Install project dependencies using Yarn:
yarn add jquery jquery-mask-plugin @fancyapps/ui swiper aos --save
```

## Task Execution

```sh
# Execute tasks using Yarn:
yarn start
```

## License & Attribution

MIT © [Kleyton Caires](https://linkedin.com/in/kleytoncaires).

This project is inspired by the work of many awesome developers especially those who contribute to this project, Gulp.js, Babel, and many other dependencies as listed in the `package.json` file. FOSS (Free & Open Source Software) for the win.
