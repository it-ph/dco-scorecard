const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/assets/css/theme/steps.css',
    'resources/assets/css/mystyle.css',
    'resources/assets/css/theme/bootstrap.min.css',

    'resources/assets/css/theme/scss/icons/font-awesome/css/font-awesome.min.css',
    'resources/assets/css/theme/scss/icons/simple-line-icons/css/simple-line-icons.css',
    'resources/assets/css/theme/scss/icons/weather-icons/css/weather-icons.min.css',
    'resources/assets/css/theme/scss/icons/linea-icons/linea.css',
    'resources/assets/css/theme/scss/icons/themify-icons/themify-icons.css',
    'resources/assets/css/theme/scss/icons/flag-icon-css/flag-icon.min.css',
    'resources/assets/css/theme/scss/icons/material-design-iconic-font/css/materialdesignicons.min.css',
    'resources/assets/css/theme/scss/spinners.css',
    'resources/assets/css/theme/scss/animate.css',

    'resources/assets/css/theme/theme-style.css',
    'resources/assets/css/theme/default-dark.css',

], 'public/css/dco-scorecard.css');