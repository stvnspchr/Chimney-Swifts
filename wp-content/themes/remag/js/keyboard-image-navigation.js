jQuery( document ).ready( function( $ ) {
	alert("Here!");
	jQuery( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // Left arrow key code
			url = jQuery( '.slidesjs-previous a' ).attr( 'href' );
			alert(url);
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = jQuery( '.entry-attachment a' ).attr( 'href' );
			alert(url);
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
	} );
} );