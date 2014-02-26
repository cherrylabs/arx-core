/**
java -jar compiler.jar --js $FileName$ --js_output_file ../inc/debug.js --compilation_level ADVANCED_OPTIMIZATIONS --output_wrapper "(function(){%output%})()"
*/

if ( typeof debugInitialized === 'undefined' ) {
	debugInitialized = 1;
	var debug = {
		visiblePluses : [], // all visible toggle carets
		currentPlus   : -1, // currently selected caret

		selectText : function( element ) {
			var selection = window.getSelection(),
				range = document.createRange();

			range.selectNodeContents(element);
			selection.removeAllRanges();
			selection.addRange(range);
		},

		hasClass : function( target, className ) {
			if ( typeof className === 'undefined' ) {
				className = 'debug-show';
			}

			return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
		},

		addClass : function( ele, className ) {
			if ( typeof className === 'undefined' ) {
				className = 'debug-show';
			}

			debug.removeClass(ele, className).className += (" " + className);
		},

		removeClass : function( ele, className ) {
			if ( typeof className === 'undefined' ) {
				className = 'debug-show';
			}

			ele.className = ele.className.replace(
				new RegExp('(\\s|^)' + className + '(\\s|$)'), ' '
			);
			return ele;
		},

		next : function( element ) {
			do {
				element = element.nextElementSibling;
			} while ( element.nodeName.toLowerCase() !== 'dd' );

			return element;
		},

		toggle : function( element, hide ) {
			var parent = debug.next(element);

			if ( typeof hide === 'undefined' ) {
				hide = debug.hasClass(element);
			}

			if ( hide ) {
				debug.removeClass(element);
			} else {
				debug.addClass(element);
			}

			if ( parent.childNodes.length === 1 ) {
				parent = parent.childNodes[0].childNodes[0]; // reuse variable cause I can

				if ( debug.hasClass(parent, 'debug-parent') ) {
					debug.toggle(parent, hide)
				}
			}
		},

		toggleChildren : function( element, hide ) {
			var parent = debug.next(element)
				, nodes = parent.getElementsByClassName('debug-parent')
				, i = nodes.length;

			if ( typeof hide === 'undefined' ) {
				hide = debug.hasClass(element);
			}

			while ( i-- ) {
				debug.toggle(nodes[i], hide);
			}
			debug.toggle(element, hide);
		},

		toggleAll : function( caret ) {
			var elements = document.getElementsByClassName('debug-parent'),
				i = elements.length,
				visible = debug.hasClass(caret.parentNode);

			while ( i-- ) {
				debug.toggle(elements[i], visible);
			}
		},

		switchTab : function( target ) {
			var lis, el = target, index = 0;

			target.parentNode.getElementsByClassName('debug-active-tab')[0].className = '';
			target.className = 'debug-active-tab';

			// take the index of clicked title tab and make the same n-th content tab visible
			while ( el = el.previousSibling ) el.nodeType === 1 && index++;
			lis = target.parentNode.nextSibling.childNodes;
			for ( var i = 0; i < lis.length; i++ ) {
				if ( i === index ) {
					lis[i].style.display = 'block';

					if ( lis[i].childNodes.length === 1 ) {
						el = lis[i].childNodes[0].childNodes[0];

						if ( debug.hasClass(el, 'debug-parent') ) {
							debug.toggle(el, false)
						}
					}
				} else {
					lis[i].style.display = 'none';
				}
			}
		},

		isSibling : function( el ) {
			for ( ; ; ) {
				el = el.parentNode;
				if ( !el || debug.hasClass(el, 'debug') ) {
					break;
				}
			}

			return !!el;
		},

		fetchVisiblePluses : function() {
			debug.visiblePluses = [];
			Array.prototype.slice.call(document.querySelectorAll('.debug nav, .debug-tabs>li:not(.debug-active-tab)'), 0)
				.forEach(
				function( el ) {
					if ( el.offsetWidth !== 0 || el.offsetHeight !== 0 ) {
						debug.visiblePluses.push(el)
					}
				}
			);
		},

		keyCallBacks : {
			cleanup : function( i ) {
				var focusedClass = 'debug-focused';
				var prevElement = document.querySelector('.' + focusedClass);
				prevElement && debug.removeClass(prevElement, focusedClass);

				if ( i !== -1 ) {
					var el = debug.visiblePluses[i];
					debug.addClass(el, focusedClass);


					var offsetTop = function( el ) {
						return el.offsetTop + ( el.offsetParent ? offsetTop(el.offsetParent) : 0 );
					};

					var top = offsetTop(el) - (window.innerHeight / 2 );
					window.scrollTo(0, top);
				}

				debug.currentPlus = i;
			},

			moveCursor : function( up, i ) {
				// todo make the first VISIBLE plus active
				if ( up ) {
					if ( --i < 0 ) {
						i = debug.visiblePluses.length - 1;
					}
				} else {
					if ( ++i >= debug.visiblePluses.length ) {
						i = 0;
					}
				}

				debug.keyCallBacks.cleanup(i);
				return false;
			}
		}
	};

	window.addEventListener("click", function( e ) {
		var target = e.target
			, nodeName = target.nodeName.toLowerCase();

		if ( !debug.isSibling(target) ) return;

		// auto-select name of variable
		if ( nodeName === 'dfn' ) {
			debug.selectText(target);
			target = target.parentNode;
		} else if ( nodeName === 'var' ) { // stupid workaround for misc elements
			target = target.parentNode;    // to not stop event from further propagating
			nodeName = target.nodeName.toLowerCase()
		}

		// switch tabs
		if ( nodeName === 'li' && target.parentNode.className === 'debug-tabs' ) {
			if ( target.className !== 'debug-active-tab' ) {
				debug.switchTab(target);
				if ( debug.currentPlus !== -1 ) debug.fetchVisiblePluses();
			}
			return false;
		}

		// handle clicks on the navigation caret
		if ( nodeName === 'nav' ) {
			// ensure doubleclick has different behaviour, see below
			setTimeout(function() {
				var timer = parseInt(target.debugTimer, 10);
				if ( timer > 0 ) {
					target.debugTimer--;
				} else {
					debug.toggleChildren(target.parentNode); // <dt>
					if ( debug.currentPlus !== -1 ) debug.fetchVisiblePluses();
				}
			}, 300);
			e.stopPropagation();
			return false;
		} else if ( debug.hasClass(target, 'debug-parent') ) {
			debug.toggle(target);
			if ( debug.currentPlus !== -1 ) debug.fetchVisiblePluses();
			return false;
		} else if ( debug.hasClass(target, 'debug-ide-link') ) {
			e.preventDefault();
			var ajax = new XMLHttpRequest(); // add ajax call to contact editor but prevent link default action
			ajax.open('GET', target.href);
			ajax.send(null);
			return false;
		}
	}, false);

	window.addEventListener("dblclick", function( e ) {
		var target = e.target;
		if ( !debug.isSibling(target) ) return;


		if ( target.nodeName.toLowerCase() === 'nav' ) {
			target.debugTimer = 2;
			debug.toggleAll(target);
			if ( debug.currentPlus !== -1 ) debug.fetchVisiblePluses();
			e.stopPropagation();
		}
	}, false);

	// keyboard navigation
	window.onkeydown = function( e ) {

		// do nothing if alt key is pressed or if we're actually typing somewhere
		if ( e.target !== document.body || e.altKey ) return;

		var keyCode = e.keyCode
			, shiftKey = e.shiftKey
			, i = debug.currentPlus;


		if ( keyCode === 68 ) { // 'd' : toggles navigation on/off
			if ( i === -1 ) {
				debug.fetchVisiblePluses();
				return debug.keyCallBacks.moveCursor(false, i);
			} else {
				debug.keyCallBacks.cleanup(-1);
				return false;
			}
		} else {
			if ( i === -1 ) return;

			if ( keyCode === 9 ) { // TAB : moves up/down depending on shift key
				return debug.keyCallBacks.moveCursor(shiftKey, i);
			} else if ( keyCode === 38 ) { // ARROW UP : moves up
				return debug.keyCallBacks.moveCursor(true, i);
			} else if ( keyCode === 40 ) { // ARROW DOWN : down
				return debug.keyCallBacks.moveCursor(false, i);
			} else {
				if ( i === -1 ) {
					return;
				}
			}
		}


		var debugNode = debug.visiblePluses[i];
		if ( debugNode.nodeName.toLowerCase() === 'li' ) { // we're on a trace tab
			if ( keyCode === 32 || keyCode === 13 ) { // SPACE/ENTER
				debug.switchTab(debugNode);
				debug.fetchVisiblePluses();
				return debug.keyCallBacks.moveCursor(true, i);
			} else if ( keyCode === 39 ) { // arrows
				return debug.keyCallBacks.moveCursor(false, i);
			} else if ( keyCode === 37 ) {
				return debug.keyCallBacks.moveCursor(true, i);
			}
		}

		debugNode = debugNode.parentNode; // simple dump
		if ( keyCode === 32 || keyCode === 13 ) { // SPACE/ENTER : toggles
			debug.toggle(debugNode);
			debug.fetchVisiblePluses();
			return false;
		} else if ( keyCode === 39 || keyCode === 37 ) { // ARROW LEFT/RIGHT : respectively hides/shows and traverses
			var visible = debug.hasClass(debugNode);
			var hide = keyCode === 37;

			if ( visible ) {
				debug.toggleChildren(debugNode, hide); // expand/collapse all children if immediate ones are showing
			} else {
				if ( hide ) { // LEFT
					// traverse to parent and THEN hide
					do {debugNode = debugNode.parentNode} while ( debugNode && debugNode.nodeName.toLowerCase() !== 'dd' );

					if ( debugNode ) {
						debugNode = debugNode.previousElementSibling;

						i = -1;
						var parentPlus = debugNode.querySelector('nav');
						while ( parentPlus !== debug.visiblePluses[++i] ) {}
						debug.keyCallBacks.cleanup(i)
					} else { // we are at root
						debugNode = debug.visiblePluses[i].parentNode;
					}
				}
				debug.toggle(debugNode, hide);
			}
			debug.fetchVisiblePluses();
			return false;
		}
	};
}

// debug purposes only, removed in minified source
function clg( i ) {
	if ( !window.console )return;
	var l = arguments.length, o = 0;
	while ( o < l )console.log(arguments[o++])
}
