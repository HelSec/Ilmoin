const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/assets/js')
    .postCss('resources/css/app.css', 'public/assets/css')
    .options({
        postCss: [
            require('postcss-import')(),
            require('tailwindcss')('./tailwind.config.js'),
            require('postcss-nesting')(),
        ]
    });

if (mix.inProduction()) {
    mix.version();
}
