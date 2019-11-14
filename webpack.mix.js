const mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/assets/js')
    .postCss('resources/css/app.css', 'public/assets/css')
    .options({
        postCss: [
            require('postcss-import')(),
            require('tailwindcss')('./tailwind.config.js'),
            require('postcss-nesting')(),
        ]
    })
    .purgeCss({
        whitelistPatterns: [/vs__/],
    });

if (mix.inProduction()) {
    mix.version();
}
