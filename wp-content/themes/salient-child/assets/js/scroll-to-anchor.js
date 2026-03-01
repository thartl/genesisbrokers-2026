/**
 *
 * Requires pw-jump.js
 *
 */


( function( $ ) {

  $( document ).ready( function() {

    let duration = 500;

    // Smooth-scroll to anchor after load, if url has a hash
    if ( location.hash ) {

      let $anchor = location.hash;
      $anchor = $anchor.length ? $anchor : $( '[name=' + this.hash.slice( 1 ) + ']' );

      // If anchor exists on this page...
      if ( $anchor.length ) {

        // Stop document from scrolling after load (timeout for compatibility)
        setTimeout( function() {
          window.scrollTo( 0, 0 );
        }, 1 );

        // pageYOffset needs a moment
        setTimeout( function() {
          scrollToAnchor( $anchor, 720 );
        }, 100 );
      }

    }


    // Smooth-scroll on click to anchor on the same page
    $( 'a[href*="#"]:not([href="#"]):not([href^="#tab"])' ).on( 'click', function( e ) {

      if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' )
          && location.hostname == this.hostname ) {

        e.preventDefault();
        e.stopPropagation();

        let hashOnly = this.hash;
        let thisID = $( hashOnly );
        let target = thisID.length ? hashOnly : $( '[name=' + this.hash.slice( 1 ) + ']' );

        // Smooth scroll to anchor (or to end of page)
        if ( target.length ) {

          // Redundant...
          // if ( hashOnly == '' || hashOnly == '#' || hashOnly == undefined )
          //   return false;

          scrollToAnchor( target, 0 );
        }

        setTimeout( function() {

          // Deactivate mobile menu button
          $( '.menu-toggle, .genesis-responsive-menu' )
          .removeClass( 'activated' )
          .attr( 'aria-expanded', false )
          .attr( 'aria-pressed', false );

          // Collapse primary menu, if it's expanded (and we're on mobile)
          if ( $( '.genesis-responsive-menu' ).css( 'display' ) == 'block'
              && $( '.menu-toggle' ).css( 'display' ) == 'block' ) {

            $( '.genesis-responsive-menu' ).slideToggle( 'fast' );

          }

          // Add hash to url - or not, because Chrome jumpy -- maybe stick this into browser history instead?
          // location.hash = hashOnly;
        }, ( duration * 1.1 ) );

      }

    } );


    function scrollToAnchor( anchor, delay ) {

      let docHeight = document.body.clientHeight;
      let windowHeight = $( window ).innerHeight();
      let maxDistance = docHeight - windowHeight;
      let anchorOffset = $( anchor ).offset().top - window.pageYOffset;
      let scrollDistance = maxDistance > anchorOffset ? anchorOffset : maxDistance;

      // Smooth-scroll document
      setTimeout( function() {

        // Offset only when scrolling up, because sticky header (but that's only on career pages)
        // var offset = ( scrollDistance > 0 || !$( 'body' ).hasClass( 'job-offers' ) ) ? 0 : -87;
        var offset = -10;

        jump( scrollDistance, {
          duration: duration,
          offset: offset,
        } );
      }, delay );

    }


  } );

} )( jQuery );

