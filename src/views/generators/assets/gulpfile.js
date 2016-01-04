/* jshint ignore: start */
/**
 * Angular ES6 Webpack Babel
 */
var config = require('./gulpconfig.js');
var _ = require('lodash');
var fs = require('fs');
var del = require('del');
var args = require('yargs').argv;
var gulp = require('gulp-help')(require('gulp'));
var $ = require('gulp-load-plugins')();

// apply template paths
config = applyConfiguration(config);

// write .jshintrc from config
fs.writeFile('.jshintrc', JSON.stringify(config.jshint));

// hide console notify text
$.notify.logLevel(0);


gulp.task('default', 'Default tasks', ['clean'], function () {
    gulp.start('copy', 'css', 'js', 'img', 'html');

    if (args.watch) {
        gulp.start('watch');
    }

    gulp.src('./').pipe($.notify(' ʕ•ᴥ•ʔ <( Build complete! ) '));
    $.util.log($.util.colors.inverse(' ʕ•ᴥ•ʔ <( Build complete! ) '));
});


/**
 * Clean task
 */
gulp.task('clean', 'Clean dist folder', function (callback) {
    del([ config.dir.dist + '/*' ], callback);
});


/**
 * CSS task
 */
gulp.task('css', 'Handle CSS', function () {
    _.each(config.files.css, function (value, name) {
        // force array
        if (Object.prototype.toString.call(value) !== '[object Array]') {
            value = [value];
        }

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            .pipe($.sass({errLogToConsole: true}))
            .pipe($.autoprefixer(config.autoprefixer))
            .pipe($.rename(name))
            .pipe($.sourcemaps.write('./', { includeContent: true }))
            .pipe(gulp.dest(config.dir.dist + '/css'));

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            .pipe($.sass({errLogToConsole: true}))
            .pipe($.autoprefixer(config.autoprefixer))
            .pipe($.csso({ disableStructureMinimization: false }))
            .pipe($.rename({ extname: '.min.css' }))
            .pipe($.sourcemaps.write('./', { includeContent: true }))
            .pipe(gulp.dest(config.dir.dist + '/css'));
    });
});


/**
 * JSHINT task
 */
gulp.task('jshint', false, function () {
    // @todo Allow to specify source
    gulp.src([
        config.dir.src + '/js/**/*.js',
        '!**/plugins/**'
    ])
        .pipe($.plumber({
            errorHandler: swallowErrors
        }))
        .pipe($.jshint())
        .pipe($.jshint.reporter('jshint-stylish'))
        .pipe($.jshint.reporter('fail'));
});


/**
 * JS task
 */
gulp.task('js', 'Handle JS', ['jshint'], function () {
    _.each(config.files.js, function (value, name) {
        // force array
        if (Object.prototype.toString.call(value) !== '[object Array]') {
            value = [value];
        }

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            .pipe($.concat(name))
            .pipe($.sourcemaps.write('./', { includeContent: true }))
            .pipe(gulp.dest(config.dir.dist + '/js'));

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            .pipe($.concat(name))
            .pipe($.uglify())
            .pipe($.rename({ extname: '.min.js' }))
            .pipe($.sourcemaps.write('./', { includeContent: true }))
            .pipe(gulp.dest(config.dir.dist + '/js'));
    });

    // webpack
    _.each(config.files.webpack, function (value, name) {
        // force array
        if (Object.prototype.toString.call(value) !== '[object Array]') {
            value = [value];
        }

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            .pipe($.concat(name))
            .pipe($.webpackSourcemaps(_.extend(config.webpack, {
                watch: !!args.watch,
                output: {
                    filename: name
                }
            })))
            .pipe($.sourcemaps.write('./', { includeContent: false }))
            .pipe(gulp.dest(config.dir.dist + '/js'));

        /*gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.sourcemaps.init())
            //.pipe($.concat(name))
            .pipe($.webpackSourcemaps(_.extend(config.webpack, {
                watch: !!args.watch,
                output: {
                    filename: name.replace(/.js$/, '.min.js')
                }
            })))
            .pipe($.uglify())
            .pipe($.sourcemaps.write('./', { includeContent: false }))
            .pipe(gulp.dest(config.dir.dist + '/js'));*/
    });
});


/**
 * HTML task
 */
gulp.task('html', 'Handle Angular HTML templates', function () {
    _.each(config.files.html, function (value, name) {
        // force array
        if (Object.prototype.toString.call(value) !== '[object Array]') {
            value = [value];
        }

        gulp.src(value)
            .pipe($.plumber({
                errorHandler: swallowErrors
            }))

            .pipe($.minifyHtml(config.minifyhtml))
            .pipe(gulp.dest(config.dir.dist + '/html'));
    });
});


/**
 * IMG task
 */
gulp.task('img', 'Handle IMG', function () {
    // @todo Allow to specify source
    gulp.src(config.dir.src + '/img/*')
        .pipe($.plumber({
            errorHandler: swallowErrors
        }))

        .pipe($.imagemin(config.imagemin))
        // @todo Allow to specify destination
        .pipe(gulp.dest(config.dir.dist + '/img'));
});


/**
 * Copy Task
 */
gulp.task('copy', 'Copy files', function () {
    var file;

    _.each(config.copy, function (value, name) {
        // force array
        if (Object.prototype.toString.call(value) !== '[object Array]') {
            value = [value];
        }

        if (isFile(name, true)) {
            gulp.src(value)
                .pipe($.plumber({
                    errorHandler: swallowErrors
                }))

                .pipe($.if(/[.]html$/, $.minifyHtml(config.minifyhtml)))
                .pipe($.if(/[.]css$/, $.csso()))
                .pipe($.if(/[.]js$/, $.uglify()))
                .pipe($.rename(name))
                .pipe(gulp.dest(config.dir.dist));
        } else {
            gulp.src(value)
                .pipe($.plumber({
                    errorHandler: swallowErrors
                }))

                .pipe($.if(/[.]html$/, $.minifyHtml(config.minifyhtml)))
                .pipe($.if(/[.]css$/, $.csso()))
                .pipe($.if(/[.]js$/, $.uglify()))
                .pipe(gulp.dest(config.dir.dist + '/' + name));
        }
    });
});


/**
 * Server task
 */
gulp.task('server', false, function () {
    // @todo Put config object into gulpconfig.js
    $.connect.server({
        root: '.',
        //port: 8000,
        livereload: true
    });
});


/**
 * Watch task
 */
gulp.task('watch', 'Default tasks', ['server'], function () {
    gulp.watch(config.watch.scss, ['css']);
    gulp.watch(config.watch.js, ['js']);
    gulp.watch(config.watch.html, ['html']);
    gulp.watch(config.watch.img, ['img']);

    gulp.watch(config.livereload)
        .on('change', function (file) {
            gulp.src(file.path).pipe($.connect.reload());

            gulp.src('./').pipe($.notify(' ʕ•ᴥ•ʔ <( Reload! ) '));
            $.util.log($.util.colors.inverse(' ʕ•ᴥ•ʔ <( Reload! ) '));
        });

    $.util.log($.util.colors.inverse(' ( Ready to work! )> ᕙ(`▽´)ᕗ '));
});


/**
 * Helpers
 */

function applyConfiguration(current, config) {
    if (!config) {
        config = current;
    }

    _.forEach(current, function (value, key) {
        if (_.isString(value)) {
            current[key] = smrtr(value, config);
        } else {
            applyConfiguration(value, config);
        }
    });

    return current;
}

function isFile(name, strict) {
    var re = /(?:\.([^.]+))?$/;
    var extension = re.exec(name)[1];

    return strict ? !!extension : extension;
}

function smrtr(arr, data) {
    if (typeof arr === 'string') {
        return _.template(arr)(data);
    }

    return _.map(arr, function (item) {
        return smrtr(item, data);
    });
}

function swallowErrors(error) {
    var message = '';

    // handle specific plugin
    switch (error.plugin) {
        case 'gulp-sass':
            message = $.util.template('<%= error.message %> <%= error.fileName %> @ line <%= error.lineNumber %>', {
                error: error,
                file: null
            });
            break;

        default:
            message = error.message;
    }

    $.util.log($.util.colors.red('✖', message));

    // Details
    if (args.v || args.verbose) {
        $.util.log(error);
    }

    var notification = {
        title: '✖ Error (╥﹏╥)',
        message: message
    };

    if (error.fileName) {
        notification.message = '<%= options.filename %> @ line <%= options.line %>';
        notification.templateOptions = {
            filename: '/' + error.fileName.split('/').pop(),
            line: error.lineNumber || '?'
        };
    }

    gulp.src('./').pipe($.notify(notification));

    this.emit('end');
}
