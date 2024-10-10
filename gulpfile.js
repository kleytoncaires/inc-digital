const gulp = require('gulp')
const { parallel, series } = require('gulp')
require('dotenv').config()
const plumber = require('gulp-plumber')
const notify = require('gulp-notify')
const fs = require('fs')
const path = require('path')

const webp = require('gulp-webp')
const tinypng = require('gulp-tinypng-compress')
const uglify = require('gulp-uglify')
const sass = require('gulp-dart-sass')
const concat = require('gulp-concat')
const autoprefixer = require('gulp-autoprefixer')
const babel = require('gulp-babel')

const srcPath = 'assets/js'
const destPath = './'

function handleErrors() {
    return plumber({
        errorHandler: notify.onError((error) => `Error: ${error.message}`),
    })
}

function js() {
    const files = fs
        .readdirSync(srcPath)
        .filter((file) => path.extname(file) === '.js')

    const jsTasks = files.map((file) => {
        return gulp
            .src(path.join(srcPath, file), { sourcemaps: true })
            .pipe(handleErrors())
            .pipe(babel({ presets: ['@babel/preset-env'] }))
            .pipe(concat(file))
            .pipe(uglify())
            .pipe(gulp.dest(destPath, { sourcemaps: '.' }))
    })

    return Promise.all(jsTasks)
}

function css() {
    return gulp
        .src('assets/css/*.scss', { sourcemaps: true })
        .pipe(handleErrors())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(
            autoprefixer({
                browserlist: ['last 2 versions'],
                cascade: false,
            })
        )
        .pipe(gulp.dest('./', { sourcemaps: '.' }))
}

function optimizeImages() {
    return gulp
        .src('assets/img/**/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(
            tinypng({
                key: process.env.TINYPNG_API_KEY,
                sigFile: 'images/.tinypng-sigs',
                log: true,
            })
        )
        .pipe(gulp.dest('assets/img'))
}

function convertToWebP() {
    return gulp
        .src('assets/img/**/*.+(jpg|jpeg|png)')
        .pipe(webp())
        .pipe(gulp.dest('assets/img/webp'))
}

function watchFiles() {
    gulp.watch('assets/css/**/*.scss', css)
    gulp.watch('assets/js/*.js', js)
}

exports.default = series(parallel(css, js), watchFiles)
exports.build = parallel(css, js, optimizeImages, convertToWebP)
