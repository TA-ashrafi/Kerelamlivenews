/**
 * KeralamLiveNews front-end interactions:
 * mobile nav toggle, header search toggle, strip arrows, AJAX infinite scroll.
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

		/* AJAX Infinite Scroll for Category & Archive Grids */
		var grid = document.getElementById( 'klm-archive-grid' );
		var loader = document.getElementById( 'klm-loader' );
		var endMsg = document.getElementById( 'klm-end-msg' );

		if ( grid && window.klm_ajax ) {
			var page = 1;
			var maxPages = parseInt( grid.getAttribute( 'data-maxpages' ), 10 ) || 1;
			var catId = parseInt( grid.getAttribute( 'data-cat' ), 10 ) || 0;
			var showAuthor = grid.getAttribute( 'data-showauthor' ) === '1';
			var showDate = grid.getAttribute( 'data-showdate' ) === '1';
			var loading = false;

			if ( maxPages <= 1 && endMsg ) {
				endMsg.style.display = 'block';
			}

			window.addEventListener( 'scroll', function () {
				if ( loading || page >= maxPages ) {
					return;
				}
				var scrollPos = window.innerHeight + window.scrollY;
				var threshold = document.body.offsetHeight - 600;

				if ( scrollPos >= threshold ) {
					loading = true;
					if ( loader ) {
						loader.style.display = 'block';
					}

					page++;
					var formData = new FormData();
					formData.append( 'action', 'klm_load_more' );
					formData.append( 'nonce', window.klm_ajax.nonce );
					formData.append( 'page', page );
					formData.append( 'cat_id', catId );
					if ( showAuthor ) formData.append( 'show_author', '1' );
					if ( showDate ) formData.append( 'show_date', '1' );

					fetch( window.klm_ajax.ajax_url, {
						method: 'POST',
						body: formData
					} )
					.then( function ( response ) { return response.text(); } )
					.then( function ( html ) {
						if ( loader ) {
							loader.style.display = 'none';
						}
						if ( html.trim().length > 0 ) {
							grid.insertAdjacentHTML( 'beforeend', html );
							loading = false;
							if ( page >= maxPages && endMsg ) {
								endMsg.style.display = 'block';
							}
						} else {
							if ( endMsg ) {
								endMsg.style.display = 'block';
							}
						}
					} )
					.catch( function () {
						if ( loader ) {
							loader.style.display = 'none';
						}
						loading = false;
					} );
				}
			} );
		}

	} );
})();
