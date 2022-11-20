const mix = require('laravel-mix');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .vue();

// In production, purge CSS of unnecessary classes by filtering only those used in our JS / Vue / Blade views.
// We use the PurgeCSS plugin for PostCSS, without the Laravel wrappers, which seem deprecated as on 2022-11-20.
if (mix.inProduction()) {
    mix.options({
        postCss: [
            require("@fullhuman/postcss-purgecss")({
                content: [
                    "resources/js/**/*.js",
                    "resources/js/**/*.vue",
                    "resources/views/**/*.php",
                ],
                defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
                safelist: {
                    greedy: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
                },
            }),
        ],
    });
}
