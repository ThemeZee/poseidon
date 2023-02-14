// Include Gulp.
var gulp = require('gulp');

// Include plugins.
var rename    = require( 'gulp-rename' );
var uglify    = require( 'gulp-uglify' );
var sass      = require('gulp-sass')(require('sass'));
var postcss   = require( 'gulp-postcss' );
var sorting   = require( 'postcss-sorting' );
var stylelint = require( 'stylelint' );

// Minify JS.
gulp.task( 'minifyjs', async function() {
	return gulp.src( ['assets/js/navigation.js', 'assets/js/customize-preview.js', 'assets/js/customizer-controls.js'] )
		.pipe( uglify() )
		.pipe( rename( {
			suffix: '.min'
		} ) )
		.pipe( gulp.dest('assets/js') );
});

// Editor Styles Sass Bundler.
gulp.task( 'editor', async function() {
    return gulp.src( 'sass/editor-styles.scss' )
        .pipe( sass( { outputStyle: 'expanded' } ).on( 'error', sass.logError ) )
		.pipe( rename( 'editor-styles.css' ) )
		.pipe( postcss( [ sorting() ] ) )
		.pipe( postcss( [ stylelint( { 'fix': true } ) ] ) )
        .pipe( gulp.dest( 'assets/css' ) )
});

// Sass Bundler.
gulp.task( 'sass', async function() {
    return gulp.src( 'sass/style.scss' )
        .pipe( sass( { outputStyle: 'expanded' } ).on( 'error', sass.logError ) )
		.pipe( rename( 'style.css' ) )
		.pipe( postcss( [ sorting() ] ) )
		.pipe( postcss( [ stylelint( { 'fix': true } ) ] ) )
        .pipe( gulp.dest( './' ) )
});

// Sass Watch.
gulp.task('sass:watch', async function () {
	gulp.watch( 'sass/**/*.scss', gulp.series('sass', 'editor'));
});
