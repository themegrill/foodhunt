jQuery( document ).ready( function( $ ) {

	/*jshint unused: false */
	imageWidget = {
		uploader : function( widget_id_string ) {

			function media_upload( button_class ) {
				var _custom_media = true,
				_orig_send_attachment = wp.media.editor.send.attachment;

				$( 'body' ).on( 'click', button_class, function() {
					var button_id ='#'+$(this).attr('id');
					var button = $(button_id);
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							$('#' + widget_id_string + 'attachment_id').val(attachment.id);
							$('#' + widget_id_string ).val(attachment.url);
							$('#' + widget_id_string + 'preview').attr('src',attachment.url).css('display','block');
						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					};
					wp.media.editor.open(button);
					return false;
				});
			}
			media_upload('.custom_media_button.button');
		}
	};
});
