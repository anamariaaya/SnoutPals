import pkg from 'gulp';
const {src, dest, watch, series} = pkg;
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import postcss from 'gulp-postcss'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import sourcemaps from 'gulp-sourcemaps'
import plumber from 'gulp-plumber'
import cache from 'gulp-cache';
import imagemin from 'gulp-imagemin';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminPngquant from 'imagemin-pngquant';
import imageminSvgo from 'imagemin-svgo';


const sass = gulpSass(dartSass);

const path = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    images: 'src/images/**/*.{jpg,jpeg,png,svg,gif}'
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


export async function images(done) {
  src('src/images/**/*.{jpg,jpeg,png,svg}')
    .pipe(
      imagemin([
        imageminMozjpeg({ quality: 75, progressive: true }),
        imageminPngquant({ quality: [0.7, 0.9] }), // PNG quality range
        imageminSvgo({
          plugins: [
            { name: 'removeViewBox', active: false },
          ],
        }),
      ])
    )
    .pipe(dest('public/build/img'));
  done();
}


export async function gifImages( done ) {
    src('src/images/**/*.gif')
        .pipe( dest('public/build/img') )
    done();
}

export function clearCache(done) {
    return cache.clearAll(done);
  }



export async function dev() {
    watch(path.scss, css)
    watch(path.js, js)
    watch(path.images, images)
}

export default series( css, js, images, gifImages, dev )
 