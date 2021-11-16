const mix = require('laravel-mix');
require('dotenv').config();
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

mix.options({
    processCssUrls: false
});

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    })
        .sourceMaps()
}

// ADD YOUR COMPILED ASSETS HERE
mix.sass('resources/scss/main.scss', 'public/css');
mix.js('resources/js/EventCreate/index.js', 'public/js/event-create.js').react();

mix.browserSync({
    host: 'localhost',
    port: 3000,
    proxy: {
        target: process.env.APP_URL // Yay! Using APP_URL from the .env file!
    }
});

// add versioning 
mix.version();