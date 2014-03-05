var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var phpunit = require('gulp-phpunit');
var exec = require('child_process').exec;
var sys = require('sys');


// Run all PHPUnit tests
gulp.task('phpunit', function() {
    exec('phpunit', function(error, stdout) {
        sys.puts(stdout);
    });
});

gulp.task('watch', function () {
    gulp.watch('app/**/*.php', ['phpunit']).on('error', notify.onError());
});

// What tasks does running gulp trigger?
gulp.task('default', ['phpunit', 'watch']);