const { src, dest, parallel , series , watch } = require('gulp');
// Gulp Sass
const sass = require('gulp-sass')(require('sass'));
const fileinclude = require('gulp-file-include');
const sourcemaps = require('gulp-sourcemaps');

const minify = require('gulp-minifier');

const run = require('gulp-run-command').default;

// VARIABLES
const configs = {
    nodeRoot: './',
    vendorRoot:'src'
};

//////////////////////////////////////

// COMPILE - HTML FILES
function htmls(cb) {
    src('src/html/**')
    .pipe(dest('dist/html'));
    cb();
}

// COMPILE - SCSS STYLE
function stylecss(cb) {
    src([`src/scss/*.scss`])
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(`dist/assets/css`))

    src([`src/scss/libs/*.scss`,`src/scss/libs/**`])
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(dest(`dist/assets/css/libs`))

    cb();
}

// COMPILE - JAVASCRIPTS
function jsvendor(cb) {

    src([`src/js/**`, `!src/js/bundle.js`, `!src/js/vendors/**`])
        .pipe(fileinclude({
            prefix: '@@',
            basepath: '@root',
            context: {
                vendorRoot:configs.vendorRoot,
                build: 'dist',
                nodeRoot: configs.nodeRoot
            }
        }))
        .pipe(minify({ minify: true, minifyJS: { sourceMap: false } }))
        .pipe(dest(`dist/assets/js`));

    src([`src/js/bundle.js`])
        .pipe(fileinclude({
            prefix: '@@',
            basepath: '@root',
            context: {
                vendorRoot:configs.vendorRoot,
                build: 'dist',
                nodeRoot: configs.nodeRoot
            }
        }))
        .pipe(minify({ minify: true, minifyJS: { sourceMap: false } }))
        .pipe(dest(`dist/assets/js`));

    cb();
}

// COPYING - ASSETS & IMAGES
function assets(cb) {
    src(`src/assets/**`).pipe(dest(`dist/assets`));
    src(`src/images/**`).pipe(dest(`dist/images`));
    cb();
}

// EXPORTS COMMAND FOR COMPILE
//////////////////////////////////////

exports.build = series(htmls, jsvendor, stylecss, assets);

exports.develop = function () {
    watch([`src/js/**`]).on('change', series(jsvendor))
    watch([`src/scss/**`],{ ignoreInitial: false }, series(stylecss))
    watch([`src/html/*.html`,`src/html/**/*.html`]).on('change', series(htmls))
    watch([`src/assets/**`,`src/images/**`]).on('change', series(assets))
}

exports.watch = run(['gulp build', 'gulp develop']);
