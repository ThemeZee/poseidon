// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var rename       = require( 'gulp-rename' );
var uglify       = require( 'gulp-uglify' );
var rtlcss       = require( 'gulp-rtlcss' );
var autoprefixer = require( 'autoprefixer' );
var postcss      = require( 'gulp-postcss' );
var sorting      = require( 'postcss-sorting' );
var wprtl        = require( 'postcss-wprtl' );

// Minify JS
gulp.task( 'minifyjs', function() {
	return gulp.src( ['js/navigation.js'] )
		.pipe( uglify() )
		.pipe( rename( {
			suffix: '.min'
		} ) )
		.pipe( gulp.dest('js') );
});

// Clean up CSS
gulp.task( 'cleancss', function() {
	return gulp.src( ['style.css', 'css/*.css'], { base: './' } )
		.pipe( postcss( [ autoprefixer() ] ) )
		.pipe( postcss( [ sorting( { 'preserve-empty-lines-between-children-rules': true } ) ] ) )
		.pipe( gulp.dest( './' ) );
});

// WP RTL
gulp.task( 'wprtl', function () {
	return gulp.src( 'style.css' )
		.pipe( postcss( [ wprtl() ] ) )
		.pipe( postcss( [ sorting( { 'preserve-empty-lines-between-children-rules': true } ) ] ) )
		.pipe( rename( 'rtl.css' ) )
		.pipe( gulp.dest( './' ) );
});

// Flex RTL
gulp.task( 'flexrtl', function () {
	return gulp.src( 'css/flexslider.css' )
		.pipe( rtlcss() )
		.pipe( rename( {
			suffix: '-rtl'
		} ) )
		.pipe( gulp.dest( 'css' ) );
});

// Default Task
gulp.task( 'default', ['minifyjs', 'cleancss'] );
