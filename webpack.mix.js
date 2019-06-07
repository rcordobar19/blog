let mix = require('laravel-mix');

mix.js('src/resources/js/app.js', 'src/public/js')
    .sass('src/resources/sass/app.scss', 'src/public/css')
    .sass('node_modules/@fortawesome/fontawesome-pro/scss/fontawesome.scss', 'src/public/css')
    .copy('node_modules/@fortawesome/fontawesome-pro/webfonts/', 'src/public/fonts');
