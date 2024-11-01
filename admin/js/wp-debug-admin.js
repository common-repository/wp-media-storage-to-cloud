(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).on("click", "#wp_debug_clear", function(e) {
		 e.preventDefault();
		 jQuery.ajax({
			 type: "POST",
			 url: ajaxurl,
			 data: {
				 action: "wp_debug_clear",
			 },
			 success: function(response) {
				 window.location.reload(true);
			 }
		 });
	 });

	 function m2c_bf_notice_dismiss(event) {
			event.preventDefault();
			var that = $(this);
			$.ajax({
					type : "post",
					dataType : "json",
					url : ajaxurl,
					data : { action: "m2c_black_friday_offer_notice_dismiss" },
					success: function(response) {
							if(response.success) {
									that.fadeOut('slow');
									console.log(response)
							}
					}
			})
		}
		$(document).on('click', '.m2c-black-friday-offer .notice-dismiss', m2c_bf_notice_dismiss);

})( jQuery );
