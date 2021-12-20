const gulp = require('gulp'),
    autoprefixer = require('autoprefixer'),
    changed = require('gulp-changed'),
    composer = require('gulp-uglify/composer'),
    concat = require('gulp-concat'),
    cssnano = require('cssnano'),
    footer = require('gulp-footer'),
    format = require('date-format'),
    fs = require('fs'),
    header = require('gulp-header'),
    imagemin = require('gulp-imagemin'),
    postcss = require('gulp-postcss'),
    rename = require('gulp-rename'),
    replace = require('gulp-replace'),
    sass = require('gulp-sass')(require('sass')),
    uglifyjs = require('uglify-js'),
    uglify = composer(uglifyjs, console),
    pkg = require('./_build/config.json');

const banner = '/*!\n' +
    ' * <%= pkg.name %> - <%= pkg.description %>\n' +
    ' * Version: <%= pkg.version %>\n' +
    ' * Build date: ' + format("yyyy-MM-dd", new Date()) + '\n' +
    ' */';

const DEST_MGR = './assets/',
    CORE = './core/components/armbruster/elements/templates/',
    FAVICON_DATA_FILE = 'faviconData.json';

gulp.task('scripts-mgr', function () {
    return gulp.src([
        'source/js/mgr/imageplus.js',
        'source/js/mgr/imageplus.panel.input.js',
        'source/js/mgr/imageplus.window.editor.js',
        'source/js/mgr/imageplus.migx_renderer.js',
        'source/js/mgr/tools/JSON2.js',
        'node_modules/jquery/dist/jquery.slim.min.js',
        'source/js/mgr/jcrop/jquery.jcrop.min.js',
        'source/js/mgr/imageplus.jquery.imagecrop.js',
        'source/js/mgr/imageplus.grid.js'
    ])
        .pipe(concat('imageplus.min.js'))
        .pipe(uglify())
        .pipe(header(banner + '\n', {pkg: pkg}))
        .pipe(gulp.dest('assets/components/imageplus/js/mgr/'))
});

gulp.task('sass-mgr', function () {
    return gulp.src([
        'source/sass/mgr/imageplus.scss'
    ])
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([
            autoprefixer()
        ]))
        .pipe(gulp.dest('source/css/mgr/'))
        .pipe(postcss([
            cssnano({
                preset: ['default', {
                    discardComments: {
                        removeAll: true
                    }
                }]
            })
        ]))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(footer('\n' + banner, {pkg: pkg}))
        .pipe(gulp.dest('assets/components/imageplus/css/mgr/'))
});

gulp.task('images-mgr', function () {
    return gulp.src('./source/img/**/*.+(png|jpg|gif|svg)')
        .pipe(changed('assets/components/imageplus/img/mgr/'))
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.mozjpeg({progressive: true}),
            imagemin.optipng({optimizationLevel: 7}),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: true},
                    {cleanupIDs: true}
                ]
            })
        ]))
        .pipe(gulp.dest('assets/components/imageplus/img/'));
});

gulp.task('bump-copyright', function () {
    return gulp.src([
        'core/components/imageplus/**/*.php',
        'source/js/mgr/**/*.js',
    ], {base: './'})
        .pipe(replace(/Copyright 2015(-\d{4})? by/g, 'Copyright ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear() + ' by'))
        .pipe(replace(/(@copyright .*?) 2015(-\d{4})?/g, '$1 ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()))
        .pipe(gulp.dest('.'));
});
gulp.task('bump-version', function () {
    return gulp.src([
        'core/components/imageplus/model/imageplus/imageplus.class.php',
    ], {base: './'})
        .pipe(replace(/version = '\d+.\d+.\d+[-a-z0-9]*'/ig, 'version = \'' +  pkg.version + '\''))
        .pipe(gulp.dest('.'));
});
gulp.task('bump-options', function () {
    return gulp.src([
        'core/components/imageplus/elements/tv/input/tpl/imageplus.options.tpl',
        'core/components/imageplus/elements/tv/output/tpl/imageplus.options.tpl',
    ], {base: './'})
        .pipe(replace(/&copy; 2015(-\d{4})?/g, '&copy; ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()))
        .pipe(gulp.dest('.'));
});
gulp.task('bump-docs', function () {
    return gulp.src([
        'mkdocs.yml',
    ], {base: './'})
        .pipe(replace(/&copy; 2015(-\d{4})?/g, '&copy; ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()))
        .pipe(gulp.dest('.'));
});
gulp.task('bump', gulp.series('bump-copyright', 'bump-version', 'bump-options', 'bump-docs'));


gulp.task('watch', function () {
    // Watch .js files
    gulp.watch(['./source/js/**/*.js'], gulp.series('scripts-mgr'));
    // Watch .scss files
    gulp.watch(['./source/scss/**/*.scss'], gulp.series('sass-mgr'));
    // Watch .scss files
    gulp.watch(['./source/img/**/*.(png|jpg|gif|svg)'], gulp.series('images-mgr'));
});

// Default Task
gulp.task('default', gulp.series('scripts-mgr', 'sass-mgr', 'images-mgr', 'bump'));