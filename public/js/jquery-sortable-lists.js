/**
 * @desc jQuery plugin to sort html list also the tree structures
 * @author Vladimír Čamaj
 * @license MIT
 */

( function( $ )
{
	/**
	 * @desc jQuery plugin
	 * @param options
	 * @returns this to unsure chaining
	 */
	$.fn.sortableLists = function( options )
	{
		// Local variables. This scope is available for all the functions in this closure.
		var jQBody = $( 'body' ).css( 'position', 'relative' ),

			defaults = {
				currElClass: '',
				placeholderClass: '',
				placeholderCss: {
					'position': 'relative',
					'padding': 0
				},
				hintClass: '',
				hintCss: {
					'display': 'none',
					'position': 'relative',
					'padding': 0
				},
				hintWrapperClass: '',
				hintWrapperCss: { /* Description is below the defaults in this var section */ },
				baseClass: '',
				baseCss: {
					'position': 'absolute',
					'top': 0 - parseInt( jQBody.css( 'margin-top' ) ),
					'left': 0 - parseInt( jQBody.css( 'margin-left' ) ),
					'margin': 0,
					'padding': 0,
					'z-index': 2500
				},
				opener: {
					active: true,
					as: 'html',  // if as is not set plugin uses background image
					close: '<i class="fa fa-folder-open-o c3" style="color:#fff; cursor:pointer; font-size:1.3em;"></i>',  // or 'fa-minus c3',  // or './imgs/Remove2.png',
            		open: '<i class="fa fa-folder-o" style="color:#fff; cursor:pointer; font-size:1.3em;"></i>',  // or 'fa-plus',  // or'./imgs/Add2.png',
					openerCss: {
						'float': 'left',
						'display': 'inline-block',
						'background-position': 'center center',
						'background-repeat': 'no-repeat',
						'display': 'inline-block',
		                //'width': '18px', 'height': '18px',
		                'float': 'left',
		                'margin-left': '-35px',
		                'margin-right': '5px',
		                //'background-position': 'center center', 'background-repeat': 'no-repeat',
		                'font-size': '1em'
					},
					openerClass: ''
				},
				listSelector: 'ul',
				listsClass: '', // Used for hintWrapper and baseElement
				listsCss: {},
				insertZone: 50,
				insertZonePlus: false,
				scroll: 20,
				ignoreClass: '',
				isAllowed: function( cEl, hint, target ) { return true; },  // Params: current el., hint el.
				onDragStart: function( e, cEl ) { return true; },  // Params: e jQ. event obj., current el.
				onChange: function( cEl ) { return true; },  // Params: current el.
				complete: function( cEl ) { return true; }  // Params: current el.
			},

			setting = $.extend( true, {}, defaults, options ),

		// base element from which is counted position of draged element
			base = $( '<' + setting.listSelector + ' />' )
				.prependTo( jQBody )
				.attr( 'id', 'sortableListsBase' )
				.css( setting.baseCss )
				.addClass( setting.listsClass + ' ' + setting.baseClass ),

		// placeholder != state.placeholderNode
		// placeholder is document fragment and state.placeholderNode is document node
			placeholder = $( '<li />' )
				.attr( 'id', 'sortableListsPlaceholder' )
				.css( setting.placeholderCss )
				.addClass( setting.placeholderClass ),

		// hint is document fragment
			hint = $( '<li />' )
				.attr( 'id', 'sortableListsHint' )
				.css( setting.hintCss )
				.addClass( setting.hintClass ),

		// Is document fragment used as wrapper if hint is inserted to the empty li
			hintWrapper = $( '<' + setting.listSelector + ' />' )
				.attr( 'id', 'sortableListsHintWrapper' )
				.addClass( setting.listsClass + ' ' + setting.hintWrapperClass )
				.css( setting.listsCss )
				.css( setting.hintWrapperCss ),

		// Is +/- ikon to open/close nested lists
			opener = $( '<span />' )
				.addClass( 'sortableListsOpener ' + setting.opener.openerClass )
				.css( setting.opener.openerCss )
				.on( 'mousedown', function( e )
				{
					var li = $( this ).closest( 'li' );

					if ( li.hasClass( 'sortableListsClosed' ) )
					{
						open( li );
					}
					else
					{
						close( li );
					}

					return false; // Prevent default
				} );

	

		// Container with all actual elements and parameters
		var state = {
			isDragged: true,
			isRelEFP: null,  // How browser counts elementFromPoint() position (relative to window/document)
			oEl: null, // overElement is element which returns elementFromPoint() method
			rootEl: null,
			cEl: null, // currentElement is currently dragged element
			upScroll: false,
			downScroll: false,
			pX: 0,
			pY: 0,
			cX: 0,
			cY: 0,
			isAllowed: true, // The function is defined in setting
			e: { pageX: 0, pageY: 0, clientX: 0, clientY: 0 }, // TODO: unused??
			doc: $( document ),
			win: $( window )
		};

		if ( setting.opener.active )
		{
			if ( ! setting.opener.open ) throw 'Opener.open value is not defined. It should be valid url, html or css class.';
			if ( ! setting.opener.close ) throw 'Opener.close value is not defined. It should be valid url, html or css class.';

			$( this ).find( 'li' ).each( function()
			{
				var li = $( this );

				if ( li.children( setting.listSelector ).length )
				{
					opener.clone( true ).prependTo( li.children( 'div' ).first() );

					if ( ! li.hasClass( 'sortableListsOpen' ) )
					{
						close( li );
					}
					else
					{
						open( li );
					}
				}
			} );
		}
	
		function open( li )
		{
			li.removeClass( 'sortableListsClosed' ).addClass( 'sortableListsOpen' );
			li.children( setting.listSelector ).css( 'display', 'block' );

			var opener = li.children( 'div' ).children( '.sortableListsOpener' ).first();

			if ( setting.opener.as == 'html' )
			{
				opener.html( setting.opener.close );
			}
			else if ( setting.opener.as == 'class' )
			{
				opener.addClass( setting.opener.close ).removeClass( setting.opener.open );
			}
			else
			{
				opener.css( 'background-image', 'url(' + setting.opener.close + ')' );
			}
		}

		/**
		 * @desc Handles opening nested lists
		 * @param li
		 */
		function close( li )
		{
			li.removeClass( 'sortableListsOpen' ).addClass( 'sortableListsClosed' );
			li.children( setting.listSelector ).css( 'display', 'none' );

			var opener = li.children( 'div' ).children( '.sortableListsOpener' ).first();

			if ( setting.opener.as == 'html' )
			{
				opener.html( setting.opener.open );
			}
			else if ( setting.opener.as == 'class' )
			{
				opener.addClass( setting.opener.open ).removeClass( setting.opener.close );
			}
			else
			{
				opener.css( 'background-image', 'url(' + setting.opener.open + ')' );
			}

		}

		/////// Enf of open/close handlers //////////////////////////////////////////////


	};

}( jQuery ));