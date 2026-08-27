/**
 * KeralamLiveNews front-end interactions:
 * mobile nav toggle, header search toggle, tab switching, strip arrows.
 *
 * @package KeralamLiveNews
 */
(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		/* Mobile nav toggle */
		var navToggle = document.querySelector( '.klm-nav__toggle' );
		var navMenu = document.querySelector( '.klm-nav__menu' );
		if ( navToggle && navMenu ) {
			navToggle.addEventListener( 'click', function () {
				var isOpen = navMenu.classList.toggle( 'is-open' );
				navToggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
			} );
		}

		/* Header search toggle */
		var searchToggle = document.querySelector( '.klm-header__search-toggle' );
		var searchPanel = document.querySelector( '.klm-header__search-panel' );
		if ( searchToggle && searchPanel ) {
			searchToggle.addEventListener( 'click', function () {
				var isOpen = searchPanel.classList.toggle( 'is-open' );
				searchToggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
				if ( isOpen ) {
					var field = searchPanel.querySelector( 'input[type="search"]' );
					if ( field ) {
						field.focus();
					}
				}
			} );
		}

		/* Tabs (Today's Keralam style widgets) */
		document.querySelectorAll( '.klm-tabs' ).forEach( function ( tabs ) {
			var buttons = tabs.querySelectorAll( '.klm-tabs__btn' );
			buttons.forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					var targetId = btn.getAttribute( 'data-tab' );
					tabs.querySelectorAll( '.klm-tabs__btn' ).forEach( function ( b ) {
						b.classList.remove( 'is-active' );
					} );
					tabs.querySelectorAll( '.klm-tabs__panel' ).forEach( function ( p ) {
						p.classList.remove( 'is-active' );
					} );
					btn.classList.add( 'is-active' );
					var panel = document.getElementById( targetId );
					if ( panel ) {
						panel.classList.add( 'is-active' );
					}
				} );
			} );
		} );

		/* Video / gallery strip arrows */
		document.querySelectorAll( '.klm-strip' ).forEach( function ( strip ) {
			var track = strip.querySelector( '.klm-strip__track' );
			var prev = strip.querySelector( '.klm-strip__arrow--prev' );
			var next = strip.querySelector( '.klm-strip__arrow--next' );
			if ( ! track ) {
				return;
			}
			var scrollBy = function ( dir ) {
				track.scrollBy( { left: dir * ( track.clientWidth * 0.8 ), behavior: 'smooth' } );
			};
			if ( prev ) {
				prev.addEventListener( 'click', function () { scrollBy( -1 ); } );
			}
			if ( next ) {
				next.addEventListener( 'click', function () { scrollBy( 1 ); } );
			}
		} );
	} );
})();
