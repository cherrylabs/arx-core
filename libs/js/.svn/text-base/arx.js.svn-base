// @codekit-prepend console.js
// @codekit-prepend jquery.js
// @codekit-prepend jquery.ui.core.js
// @codekit-prepend jquery.ui.widget.js
// @codekit-prepend jquery.ui.mouse.js
// @codekit-prepend jquery.ui.draggable.js
// @codekit-prepend jquery.ui.sortable.js
// @codekit-prepend bootstrap-modal.js
// @codekit-prepend bootstrap-tooltip.js
// @codekit-prepend bootstrap-collapse.js

/**
 * /arx/libs/js/arx.js
 * @author Stéphan Zych
 * @package Arx
 * @version 0.1
 */

if (!window.arx) {
	window.arx = {};
}

(function ($) {
	"use strict";


	var $sidebar = $('.arx-sidebar'),
			$content = $('.arx-content'),
			$modal = $('.arx-modal');


	var utils = {

		isIframe: function () {
			return (window.frameElement && window.frameElement.nodeName === 'IFRAME');
		}, // isIframe

		tpl: function (sTemplate, oData) {
			for (var k in oData) {
				sTemplate = sTemplate.replace(new RegExp('{' + k + '}', 'g'), oData[k]);
			}

			return sTemplate;
		} // tpl
		
	}; // utils

	
	var pane = {
		open: function (url) {
			if (url !== null || url !== undefined) {
				$('#iframe-menu').attr('src', url);
			}

			$('.pane-inner').animate({marginLeft: '-220px'}, 400).addClass('open');
		}, // open

		close: function () {
			$('.pane-inner').animate({marginLeft: 0}, 400).removeClass('open');
		} // close
	}; // pane


	var modal = {
		open: function (oParams) {// console.log(utils.isIframe(), parent.$('#iframe-modal'));
			var target = window;

			if (typeof oParams !== 'object') {
				oParams = {path: oParams};
			}

			if (utils.isIframe()) {
				target = parent;
			}

			target.$('#iframe-modal')[0].src = oParams.path;
			//target.$('#iframe-modal').attr('src', oParams.path);

			if (oParams.title) {
				target.$('#arx-modal .modal-header h3').html(oParams.title);
			}

			if (oParams.size) {
				target.$('#iframe-modal, #arx-modal').css('width', oParams.size);
				target.$('#arx-modal').css('margin-left', - (parseInt(oParams.size/2, 10)));
			}

			if (oParams.callback && typeof oParams.callback === 'function') {
				target.$('#arx-modal').unbind('hidden').on('hidden', oParams.callback);
			}
			
			target.$('#arx-modal').modal('show');
		}, // open

		close: function () {
			$('#arx-modal').modal('hide');
		} // close
	}; // modal


	var notify = {
		defaults: {
			alive: 5000,
			callback: function () {},
			fadeIn: 600,
			fadeOut: 800,
			sticky: false,
			template: '<div class="notify">{image}<div class="notify-title">{title}</div><div class="notify-content">{content}</div></div>'
		}, // defaults

		add: function (oParams) {
			var el = this, $notify = $('.notify-wrapper'), settings;

			el.settings = $.extend({}, notify.defaults, oParams);
			el.settings.image = el.settings.image ? '<div class="notify-img"><img src="' + el.settings.image + '" alt="" /></div>' : '';

			if (!$notify.length) {
				$('body').append('<div class="notify-wrapper"></div>');
				$notify = $('.notify-wrapper');
				$notify.data('count', 0);
			}

			settings = el.settings;

			$notify.data('count', $notify.data('count') + 1);

			$(utils.tpl(settings.template, el.settings))
			.attr('data-notify', $notify.data('count'))
			.appendTo($notify).css({opacity: 0})
			.animate({opacity: 1}, settings.fadeIn, function () {
				var me = this, $el = $(me), num = me.getAttribute('data-notify');

				$el
				.on('click', function () {
					el.remove(num);
				})
				.find('a')
				.on('click', function (e) {
					e.stopImmediatePropagation();
				});

				if (!settings.sticky) {
					var timer = setTimeout(function () {
						el.remove(num);
					}, settings.alive);

					$el
					.on('mouseenter', function () {
						clearTimeout(timer);
					})
					.on('mouseleave', function () {
						timer = setTimeout(function () {
							$el.remove(num);
						}, settings.alive);
					});
				}

				settings.callback(settings);
			});

		}, // add

		remove: function (num) {
			var el = this, settings = el.settings;

			$('[data-notify="' + num + '"]')
			.animate({opacity: 0}, settings.fadeOut, function () {
				$(this).animate({height: 0}, 150, function () {
					$(this).remove();
				});
			});
		}, // remove

		removeAll: function () {
			var settings = this.settings;

			$('.notify')
			.each(function () {
				$(this).animate({opacity: 0}, settings.fadeOut, function(){
					$(this).animate({height: 0}, 150, function(){
						$(this).remove();
					});
				});
			});
		} // removeAll
	}; // notify


	var submenu = {
		open: function (url) {
			
		}, // open

		close: function () {

		} // close
	};


	window.arx = {
		modal: {
			open: modal.open,
			close: modal.close
		}, // modal
 
		notify: {
			//add: notify.add,
			add: function (oParams) {
				if (utils.isIframe()) {
					parent.arx.notify.add(oParams)
				} else {
					notify.add(oParams);
				}
			},
			remove: function (iNum) {
				if (utils.isIframe()) {
					parent.arx.notify.remove(iNum)
				} else {
					notify.remove(iNum);
				}
			},
			removeAll: function () {
				if (utils.isIframe()) {
					parent.arx.notify.removeAll()
				} else {
					notify.removeAll();
				}
			}
		}, // notify

		// pane: {
		// 	open: pane.open,
		// 	close: pane.close
		// }, // pane

		utils: {} // utils
	}; // arx

}(jQuery));

/*
/!\ based on Bootstrap !!

- notifications system: ex. arx.notify({title, message, icon});
- modal: ex. arx.modal('show');
- sub-menu: arx.submenu('show', {url, size});

Must have:
- drag&drop applications to part of screen (app-container can have 2 apps)
*/