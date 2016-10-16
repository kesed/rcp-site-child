jQuery(document).ready(function($) {

    // link the last tab to the affiliate area page
	if ( $('#tabs').length ) {
		jQuery('#tabs').tabs({

			beforeActivate: function(event, ui) {

				if ( ui.newTab.data("link") === 'affiliate-area' ) {

					event.preventDefault();
					var url = $('.follow-link a').attr('href');
					location.href = url;
					return false;

				}

			}
		});
	}

});
