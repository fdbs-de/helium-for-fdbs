const mix = require('laravel-mix');
const MonacoWebpackPlugin = require('monaco-editor-webpack-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sourceMaps(true, 'source-map')
    .sass('resources/css/app.sass', 'public/css')
    .alias({
        '@': 'resources/js',
    })
    .webpackConfig({
        plugins: [new MonacoWebpackPlugin()]
    });

if (mix.inProduction()) {
    mix.version();
}
