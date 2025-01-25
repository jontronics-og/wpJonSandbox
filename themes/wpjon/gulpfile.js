const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const { deleteAsync } = require('del');
const exec = require('child_process').exec;

// Clean task
gulp.task('clean', () => {
    return deleteAsync([
        './css/min/*',
        './js/min/*'
    ]);
});

// Create min directories
gulp.task('create-dirs', (done) => {
    exec('mkdir -p ./css/min ./js/min', (err) => {
        if (err) console.log(err);
        done();
    });
});

// CSS Tasks
gulp.task('css', () => {
    return gulp.src('./css/*.css')
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./css/min'));
});


// JavaScript Tasks
gulp.task('js', () => {
    return gulp.src([
        './js/dropdown.js',
        './js/headerNav.js',
        './js/heroAnimations.js',
        './js/homePageContent.js',
        './js/singleBlog.js',
        './js/testimonialsBackGround.js',
        './js/workwork.js',
        './js/surf-app.js',
        './js/drum-machine-app.js'
    ])
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./js/min'));
});

// Watch Task
gulp.task('watch', () => {
    gulp.watch('./css/*.css', gulp.series('css'));
    gulp.watch('./js/*.js', gulp.series('js'));
});

// Set permissions
gulp.task('permissions', (done) => {
    exec('find . -type d -exec chmod 755 {} \\; && find . -type f -exec chmod 644 {} \\;', (err) => {
        if (err) console.log(err);
        done();
    });
});

// Default Task (development)
gulp.task('default', gulp.series('css', 'js', 'watch'));

// Production Task
gulp.task('production', gulp.series(
    'clean',
    'create-dirs',
    'css',
    'js',
    'permissions'
));