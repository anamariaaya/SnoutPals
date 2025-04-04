import {src, dest, watch, series, parallel} from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import postcss from 'gulp-postcss'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import sourcemaps from 'gulp-sourcemaps'
import plumber from 'gulp-plumber'
import imagemin from 'gulp-imagemin'
import cache from 'gulp-cache'
import webp from 'gulp-webp'

const sass = gulpSass(dartSass);

const path = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
}

export async function css( done ) {
    src(path.scss) // Identificar el archivo .SCSS a compilar
        .pipe(sourcemaps.init())
        .pipe( plumber())
        .pipe(sass().on('error', sass.logError))
        .pipe( postcss([ autoprefixer(), cssnano() ]) )
        .pipe(sourcemaps.write('.'))
        .pipe(  dest('public/build/css') );
    done();
}

export async function js( done ) {
    src(path.js)
        .pipe( dest('public/build/js') )
    done();
}

//transform all images to webp except svg and gif
export async function versionWebP( done ) {
    const opts = {
        quality: 50
    };
    src('src/images/**/*.{png,jpg}')
        .pipe( webp(opts) )
        .pipe( dest('public/build/img') )
    done();
}

export async function images( done ) {
    const options = {
        optimizationLevel: 7
    }
    src('src/images/**/*.svg')
        .pipe( cache( imagemin(options) ) )
        .pipe( dest('public/build/img') )
    done();
}

export async function gifImages( done ) {
    src('src/images/**/*.gif')
        .pipe( dest('public/build/img') )
    done();
}



export async function dev() {
    watch(path.scss, css)
    watch(path.js, js)
}

export default series( css, js, versionWebP, images, gifImages, dev )
 