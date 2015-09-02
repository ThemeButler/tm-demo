( function($) {

	var demo = {

        init: function () {

			this.iframe = $( '#iframe' );
			this.overlay = $( '.uk-overlay-panel' );

			// Fire demo change */
			$( '[data-uk-dropdown]' ).find( 'li' ).click( function( e ) {

                e.preventDefault();

				demo.changeDemo( $( this ).find( 'a' ) );

			} );

			// Fire resize.
            this.resize();

            // Apply overlay;
            this.applyOverlay();

            $( window ).bind( 'resize', function() {

                demo.resize();

            } );

        },

        resize: function() {

            var width = $( window ).width(),
                headerHeight = $( 'header' ).height(),
                height = $( window ).height() - headerHeight,
                size = {
                    top: headerHeight,
                    left: 0,
                    width: width,
                    height: height
                };

            // Resize iframe and overlay.
            this.iframe.css( size );

        },

        changeDemo: function( element ) {

			$( '.tm-select-text' ).text( element.text() );

        	this.applyOverlay();
			this.iframe.attr( 'src', element.attr( 'href' ) );

			// Replace Purchase link.
			var domain = $( '.tm-download' ).data( 'tb-domain' );

			$( '.tm-download' ).attr( 'href', domain + '/' + element.text().toLowerCase().replace( ' ', '-' ) );

        },

        applyOverlay: function() {

        	this.overlay.fadeIn();

            this.iframe.bind( 'load', function() {

                demo.overlay.fadeOut();

            });

        }

    };


    $( function() {

    	// Fire the demo.
        demo.init();

    })

})(jQuery);