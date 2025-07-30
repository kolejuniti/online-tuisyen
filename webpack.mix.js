const mix = require('laravel-mix');
const path = require('path');

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

// Configure Vue 3
mix.js('resources/js/app.js', 'public/js')
   .vue({ version: 3 })
   .sass('resources/sass/app.scss', 'public/css')
   .options({
       processCssUrls: false
   });

// Add source maps for development
if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}

// Configure aliases for Vue components
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@components': path.resolve('resources/js/components')
        }
    }
});