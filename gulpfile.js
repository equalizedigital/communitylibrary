const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

// Paths
const paths = {
    styles: {
        src: 'src/scss/**/*.scss',  // Source SCSS files
        dest: 'assets/css/'        // Destination for compiled CSS
    },
    scripts: {
        src: 'src/js/**/*.js',     // Source JavaScript files
        dest: 'assets/js/'         // Destination for minified JS
    }
};

// Compile SCSS into CSS
function styles() {
    return gulp.src(paths.styles.src)
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError)) // Compile and minify SCSS
        .pipe(rename({ suffix: '.min' })) // Rename to *.min.css
        .pipe(gulp.dest(paths.styles.dest));
}

// Minify and Concatenate JS
function scripts() {
    return gulp.src(paths.scripts.src)
        .pipe(concat('script.js')) // Combine all JS files into one
        .pipe(uglify()) // Minify the JavaScript
        .pipe(rename({ suffix: '.min' })) // Rename to *.min.js
        .pipe(gulp.dest(paths.scripts.dest));
}

// Watch for changes
function watchFiles() {
    gulp.watch(paths.styles.src, styles);
    gulp.watch(paths.scripts.src, scripts);
}

// Define gulp tasks
const build = gulp.series(gulp.parallel(styles, scripts));
const watch = gulp.series(build, watchFiles);

exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;
exports.default = build;
