/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {
	var body, menuArea, elmenuToggle, elementorNavigation, elementorHeaderMenu, resizeTimer;

	function initElementorNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var eldropdownToggle = $( '<button />', {
			'class': 'eldropdown-toggle',
			'aria-expanded': false
		} ).append( $( '<span />', {
			'class': 'screen-reader-text',
			text: elementorScreenReaderText.expand
		} ) );

		container.find( '.menu-item-has-children > a' ).after( eldropdownToggle );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'eltoggled-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'eltoggled-on' );

		// Add menu items with submenus to aria-haspopup="true".
		container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

		container.find( '.eldropdown-toggle' ).click( function( e ) {
			var _this            = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'eltoggled-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'eltoggled-on' );

			// jscs:disable
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
			screenReaderSpan.text( screenReaderSpan.text() === elementorScreenReaderText.expand ? elementorScreenReaderText.collapse : elementorScreenReaderText.expand );
		} );
	}
	initElementorNavigation( $( '.elementor-navigation' ) );

	menuArea       			= $( '#elementor-header' );
	elmenuToggle       		= menuArea.find( '#elementor-menu-toggle' );
	elementorHeaderMenu   	= menuArea.find( '#elementor-menu' );
	elementorNavigation   	= menuArea.find( '#elementor-navigation' );

	// Enable elmenuToggle.
	( function() {

		// Return early if elmenuToggle is missing.
		if ( ! elmenuToggle.length ) {
			return;
		}

		// Add an initial values for the attribute.
		elmenuToggle.add( elementorNavigation ).attr( 'aria-expanded', 'false' );

		elmenuToggle.on( 'click.actions', function() {
			$( this ).add( elementorHeaderMenu ).toggleClass( 'eltoggled-on' );

			// jscs:disable
			$( this ).add( elementorNavigation ).attr( 'aria-expanded', $( this ).add( elementorNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
		} );
	} )();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	( function() {
		if ( ! elementorNavigation.length || ! elementorNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( window.innerWidth >= 910 ) {
				$( document.body ).on( 'touchstart.actions', function( e ) {
					if ( ! $( e.target ).closest( '.elementor-navigation li' ).length ) {
						$( '.elementor-navigation li' ).removeClass( 'focus' );
					}
				} );
				elementorNavigation.find( '.menu-item-has-children > a' ).on( 'touchstart.actions', function( e ) {
					var el = $( this ).parent( 'li' );

					if ( ! el.hasClass( 'focus' ) ) {
						e.preventDefault();
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					}
				} );
			} else {
				elementorNavigation.find( '.menu-item-has-children > a' ).unbind( 'touchstart.actions' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.actions', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		elementorNavigation.find( 'a' ).on( 'focus.actions blur.actions', function() {
			$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
		} );
	} )();

	// Add the default ARIA attributes for the menu toggle and the navigations.
	function onResizeARIA() {
		if ( window.innerWidth < 910 ) {
			if ( elmenuToggle.hasClass( 'eltoggled-on' ) ) {
				elmenuToggle.attr( 'aria-expanded', 'true' );
			} else {
				elmenuToggle.attr( 'aria-expanded', 'false' );
			}

			if ( elementorHeaderMenu.hasClass( 'eltoggled-on' ) ) {
				elementorNavigation.attr( 'aria-expanded', 'true' );
			} else {
				elementorNavigation.attr( 'aria-expanded', 'false' );
			}

			elmenuToggle.attr( 'aria-controls', 'site-navigation' );
		} else {
			elmenuToggle.removeAttr( 'aria-expanded' );
			elementorNavigation.removeAttr( 'aria-expanded' );
			elmenuToggle.removeAttr( 'aria-controls' );
		}
	}
} )( jQuery );