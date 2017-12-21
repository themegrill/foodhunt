/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery(document).ready(function() {

   jQuery('#customize-info .preview-notice').append(
		'<a class="themegrill-pro-info" href="https://themegrill.com/themes/foodhunt-pro/" target="_blank">{pro}</a>'
		.replace('{pro}',foodhunt_customizer_obj.pro)
	);
});

(function ( $ ) {
		// Site title
		wp.customize( 'blogname', function ( value ) {
			value.bind( function ( to ) {
				$( '#site-title a' ).text( to );
			} );
		} );

		// Site description.
		wp.customize( 'blogdescription', function ( value ) {
			value.bind( function ( to ) {
				$( '#site-description' ).text( to );
			} );
		} );
	})( jQuery );