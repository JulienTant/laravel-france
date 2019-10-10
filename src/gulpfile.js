var gulp = require('gulp');
var shell = require('gulp-shell');
var elixir = require('laravel-elixir');
require('laravel-elixir-stylus');
var postStylus = require('poststylus');


var Task = elixir.Task;

elixir.extend('laroute', function(message) {
    new Task('laroute', function() {
        return gulp
            .src('')
            .pipe(shell('php artisan laroute:generate'))
            .pipe(new elixir.Notification('Laroute generated!'));
    }).watch('app/Http/routes.php');
});


elixir(function(mix) {
    mix.laroute();

    mix.stylus('app.styl', null, {
        "include css": true,
        use: [postStylus(['lost', 'postcss-position'])]
    });

    mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

    mix.browserify('main.js');

    mix.j

    mix.browserSync({
        proxy: 'homestead.app',
        open: false
    });
});