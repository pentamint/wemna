/**
 * File main.js.
 *
 * Series of initialize tasks.
 *
 * Please see comments below.
 */

( function( $ ) {

	// ----- Site visible after all elements are loaded. Fix object fit for IE
	$(document).ready(function() {
		objectFitImages();
	});

	// Divi Bootstrap Support
	$(document).ready(function() {
		$('.et_pb_row').wrap('<div class="container"></div>');
	});
  
} )( jQuery );
