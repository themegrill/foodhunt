/**
 * Theme Customizer related js
 */

jQuery(document).ready(function() {

   jQuery('#customize-info .preview-notice').append(
		'<a class="themegrill-pro-info" href="http://themegrill.com/themes/foodhunt-pro/" target="_blank">{pro}</a>'
		.replace('{pro}',foodhunt_customizer_obj.pro));

});
