(function ($, angular) {

    'use strict';

    var $win = $(window),
        $doc = $(document),
        $body = $('body'),
        app = null;


    app = angular.module('arx', ['ui.bootstrap', 'ui.utils', 'ngAnimate'])
        .config(function () {
            $doc
                .on('ready', function () { // console.log("-- ready");
                    if ($('iframe.fullsize, .page-content iframe').length) {
                        Util.resize(function () {
                            var $el = $('iframe.fullsize, .page-content iframe');

                            $el
                                .css({
                                    height: $body.outerHeight(),
                                    width: $el.parent().outerWidth()
                                });
                        });
                    }

                    $('[data-toggle="collapse"]')
                        .each(function () {
                            var $el = $(this),
                                target = $el.data('target') || $el.attr('href'),
                                $tmp = $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]');

                            $(target)
                                .on('show.bs.collapse', function () {
                                    $tmp
                                        .closest($el.data('parent') || '.panel')
                                        .addClass('open');

                                    $win.trigger('resize');
                                })
                                .on('hide.bs.collapse', function () {
                                    $tmp
                                        .closest($el.data('parent') || '.panel')
                                        .removeClass('open');

                                    $win.trigger('resize');
                                });
                        });

                    $('[data-toggle="sidebar"]')
                        .on('click', function () {
                            $body.toggleClass('mini-sidebar');
                            $win.trigger('resize');
                        });

                    $('.collapse.in')
                        .each(function () {
                            var target = '#' + $(this).attr('id');

                            $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
                                .closest('.panel')
                                .addClass('open');
                        });

                    $('.tab-pane.active')
                        .each(function () {
                            var $el = $(this), $target = $('[href="#'+$el.attr('id')+'"]').parent();

                            $target.addClass('active');
                        });

                    //$('.tooltip, [data-toggle="tooltip"]').tooltip();
                    //$('.tooltip, [data-toggle="popover"]').popover();

                    $('select.multiselect')
                        .each(function () {
                            var $el = $(this), datas = $el.data();

                            $el.multiselect({
                                buttonClass: datas.buttonclass || '',
                                buttonWidth: 'auto',
                                buttonContainer: '<div class="btn-group"></div>',
                                maxHeight: false,
                                buttonText: function(options) {
                                    if (options.length == 0) {
                                        return 'None selected <span class="caret"></span>';
                                    } else if (options.length > 3) {
                                        return options.length + ' selected  <span class="caret"></span>';
                                    } else {
                                        var selected = '';

                                        options.each(function() {
                                            selected += $(this).text() + ', ';
                                        });

                                        return selected.substr(0, selected.length -2) + ' <span class="caret"></span>';
                                    }
                                }
                            });
                        });

                    $('select.select2')
                        .each(function () {
                            var $el = $(this), datas = $el.data();

                            $el.select2({
                                placeholder: datas.placeholder || '',
                                minimumInputLength: datas.minimum || 0,
                                maximumSelectionSize: datas.maximum || 0
                            });
                        });

                    $win.trigger('resize');
                });
        })
        .run(function () { console.log("-- angular arx initialized");

        });
} (window.jQuery, window.angular));