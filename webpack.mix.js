const mix = require('laravel-mix');

// Compilar los archivos CSS
mix.css('resources/css/style.css', 'public/css')
   .js('resources/js/app.js', 'public/js');
