/**
 * jQuery.notifications Plugin
 * @author Stéphan Zych <info@monkeymonk.be>
 * @copyriht 2010-2011 Stéphan Zych <info@monkeymonk.be>
 * @license New BSD License <http://creativecommons.org/licenses/BSD/>
 */

(function ($) {
    'use strict';
    
    var render = function (template, data) {
        for (var k in data) {
            template = template.replace(new RegExp('{' + k + '}', 'g'), data[k]);
        }
        
        return template;
    }; // render

    var notifications = (function () {
        var defaults = {
            className: 'notification',

            alive: 4000,
            fadeIn: 600,
            fadeOut: 800,
            sticky: false,

            // Template
            tpl: '<div class="{className}"><div class="{className}-img"><img src="{image}" alt="" /></div><div class="{className}-content"><div class="{className}-title">{title}</div>{content}</div></div>',

            // Callback
            onShow: function () {},
            onHide: function () {}
        }; // defaults

        var add = function (oParams) {
            if (!$('#notifications-wrapper').length) {
                $('body').append('<div id="notifications-wrapper"></div>');
            }

            var $wrapper = $('#notifications-wrapper'),
                count = $wrapper.data('count') + 1 || 1;

            defaults = $.extend({}, defaults, oParams);

            $wrapper.data('count', count);

            $(render(defaults.tpl, defaults))
            .attr('data-id', count)
            .appendTo($wrapper).css({
                opacity: 0
            })
            .animate({
                opacity: 1
            }, defaults.fadeIn, function () {
                var self = this,
                    $self = $(self),
                    iId = parseInt(self.getAttribute('data-id'), 10);

                $self
                .on('click', function () {
                    $.notifications('remove', iId);
                })
                .find('a')
                .on('click', function (e) {
                    e.stopImmediatePropagation();
                });

                if (!defaults.sticky) {
                    $self.data('timer', setTimeout(function () {
                        $.notifications('remove', iId);
                    }, defaults.alive));

                    $self
                    .on('mouseenter', function () {
                        clearTimeout($self.data('timer'));
                    })
                    .on('mouseleave', function () {
                        $self.data('timer', setTimeout(function () {
                            $.notifications('remove', iId);
                        }, defaults.alive));
                    });
                }

                defaults.onShow(defaults);
            });
        }; // add

        var remove = function () {
            var iId = $('.' + defaults.className + ':not(.removing)').last().data('id'),
                $notification, fCallback;

            if (arguments.length) {
                if (typeof arguments[0] === 'function') {
                    fCallback = arguments[0];
                } else if (typeof arguments[1] === 'function') {
                    iId = arguments[0];

                    fCallback = arguments[1];
                } else {
                    iId = arguments[0];
                }
            }

            $notification = $('[data-id="' + iId + '"]');

            if (fCallback) {
                defaults = $.extend({}, defaults, {onHide: fCallback});
            }
            
            $notification
            .addClass('removing')
            .animate({
                opacity: 0
            }, defaults.fadeOut, function () {
                $notification.animate({
                    height: 0
                }, 150, function () {
                    clearTimeout($notification.data('timer'));

                    $notification.remove();

                    defaults.onHide(defaults);
                });
            });
        }; // remove

        var removeAll = function (fCallback) {
            if (typeof fCallback === 'function') {
                defaults = $.extend({}, defaults, {onHide: fCallback});
            }

            $('.' + defaults.className)
            .each(function () {
                $.notifications('remove', this.getAttribute('data-id'), {onHide: null});
            });

            $('#notifications-wrapper').data('count', 0);

            defaults.onHide(defaults);
        }; // removeAll

        return {
            add: add,
            remove: remove,
            removeAll: removeAll
        };
    } ()); // notifications

    
    $.notifications = function (options) {
        if (notifications[options]) {
            return notifications[options].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof options === 'object' || !options) {
            return notifications.add.apply(this, arguments);
        } else {
            $.error('Method "' + arguments[0] + '" does not exist in $.notifications plugin!');
        }
    }; // $.notifications

    // Data-API
    $(document)
    .on('click.notification.data-api', '[data-toggle="notification"]', function (e) {
        var $self = $(this), data = $self.data();

        e.preventDefault();

        $.notifications('add', data);
    });
    
})(jQuery); // jQuery.notifications() by Stéphan Zych (monkeymonk.be)
