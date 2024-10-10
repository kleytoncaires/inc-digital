import dotenv from 'dotenv'
import fs from 'fs'
import gulp, { parallel, series } from 'gulp'
import autoprefixer from 'gulp-autoprefixer'
import babel from 'gulp-babel'
import concat from 'gulp-concat'
import sass from 'gulp-dart-sass'
import notify from 'gulp-notify'
import plumber from 'gulp-plumber'
import tinypng from 'gulp-tinypng-compress'
import uglify from 'gulp-uglify'
import webp from 'gulp-webp'
import path from 'path'

dotenv.config()

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
                overrideBrowserslist: ['last 2 versions'],
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

export default series(parallel(css, js), watchFiles)
export const build = parallel(css, js, optimizeImages, convertToWebP)
