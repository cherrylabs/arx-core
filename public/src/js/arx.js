(function ($, angular) {
    'use strict';

    var $win = $(window),
        $doc = $(document),
        $body = $('body'),
        app = null;


    app = angular.module('arx', ['ui.bootstrap', 'ui.utils'])
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

            // if ($('.column').length) {
            //     $('.column')
            //     .sortable({
            //         connectWith: '.column',
            //         update: function (e, ui) {
            //             // var list = ui.item.parent('.row'),
            //             //     pos = 0;

            //             // $(list.find('.column'))
            //             // .each(function () {console.log($(this));
            //             //     pos++;

            //             //     $(this).attr('data-position', pos);
            //             // });


            //             console.log('...do something when DOM has been update (by sortable)', list);
            //         }
            //     })
            //     .disableSelection();
            // }

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

            $('.tooltip, [data-toggle="tooltip"]').tooltip();
            $('.tooltip, [data-toggle="popover"]').popover();

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


            /* Set the defaults for DataTables initialisation */
            $.extend(true, $.fn.dataTable.defaults, {
                "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page"
                }
            });

            /* Default class modification */
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper form-inline",
                "sFilterInput": "form-control input-sm",
                "sLengthSelect": "form-control input-sm"
            });

            /* API method to get paging information */
            $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };

            /* Bootstrap style pagination control */
            $.extend($.fn.dataTableExt.oPagination, {
                "bootstrap": {
                    "fnInit": function (oSettings, nPaging, fnDraw) {
                        var oLang = oSettings.oLanguage.oPaginate;
                        var fnClickHandler = function (e) {
                            e.preventDefault();

                            if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                                fnDraw(oSettings);
                            }
                        };

                        $(nPaging).append(
                            '<ul class="pagination">'+
                                '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
                                '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
                            '</ul>'
                        );

                        var els = $('a', nPaging);
                        $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                        $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                    },

                    "fnUpdate": function (oSettings, fnDraw) {
                        var iListLength = 5,
                            oPaging = oSettings.oInstance.fnPagingInfo(),
                            an = oSettings.aanFeatures.p,
                            i, ien, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength/2);

                        if (oPaging.iTotalPages < iListLength) {
                            iStart = 1;
                            iEnd = oPaging.iTotalPages;
                        }
                        else if (oPaging.iPage <= iHalf) {
                            iStart = 1;
                            iEnd = iListLength;
                        } else if (oPaging.iPage >= (oPaging.iTotalPages-iHalf)) {
                            iStart = oPaging.iTotalPages - iListLength + 1;
                            iEnd = oPaging.iTotalPages;
                        } else {
                            iStart = oPaging.iPage - iHalf + 1;
                            iEnd = iStart + iListLength - 1;
                        }

                        for (i = 0, ien = an.length; i < ien; i++) {
                            // Remove the middle elements
                            $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                            // Add the new list items and their event handlers
                            for ( j = iStart; j <= iEnd; j++) {
                                sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';

                                $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                                .insertBefore($('li:last', an[i])[0])
                                .bind('click', function (e) {
                                    e.preventDefault();
                                    oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                    fnDraw(oSettings);
                                });
                            }

                            // Add / remove disabled classes from the static elements
                            if (oPaging.iPage === 0) {
                                $('li:first', an[i]).addClass('disabled');
                            } else {
                                $('li:first', an[i]).removeClass('disabled');
                            }

                            if (oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0) {
                                $('li:last', an[i]).addClass('disabled');
                            } else {
                                $('li:last', an[i]).removeClass('disabled');
                            }
                        }
                    }
                }
            });

            /*
             * TableTools Bootstrap compatibility
             * Required TableTools 2.1+
             */
            if ($.fn.DataTable.TableTools) {
                TableToolsInit.sSwfPath = "../../dataTables-tabletools/media/swf/ZeroClipboard.swf";

                // Set the classes that TableTools uses to something suitable for Bootstrap
                $.extend(true, $.fn.DataTable.TableTools.classes, {
                    "container": "DTTT btn-group",
                    "buttons": {
                        "normal": "btn btn-default",
                        "disabled": "disabled"
                    },
                    "collection": {
                        "container": "DTTT_dropdown dropdown-menu",
                        "buttons": {
                            "normal": "",
                            "disabled": "disabled"
                        }
                    },
                    "print": {
                        "info": "DTTT_print_info modal"
                    },
                    "select": {
                        "row": "active"
                    }
                });

                // Have the collection use a bootstrap compatible dropdown
                $.extend(true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
                    "collection": {
                        "container": "ul",
                        "button": "li",
                        "liner": "a"
                    }
                });
            }

            $('.table-datatable')
            .each(function () {
                var $el = $(this);//, options = $.extend({}, $el.data());

                $el.dataTable();
            });



            $('[target="appiframe"]')
            .on('click', function (e) {
                e.preventDefault();

                var $el = $(this), href = $el.attr('href'), title = $el.attr('title');

                $el.closest('.nav').find('.active').removeClass('active');
                $el.parent().addClass('active');

                if ($el.closest('ul').is('.dropdown-menu')) {
                    $el.closest('.dropdown').addClass('active');
                }

                $('[name="appiframe"]').attr('src', href);

                History.pushState({url: href}, title, '?url='+href);
            });

            $win.trigger('resize');
        });

        $win
        .on('load', function () {
            if (History.getState().data.url) {
                $('[href="'+History.getState().data.url+'"]').trigger('click');
            }
        });
    })
    // .filter('htmlize', function () {
    //     return function () {
    //         return 'test <strong>lkg</strong>';
    //     };
    // })
    // .controller('preview', function ($scope) {
    //     console.log($scope);
    // })
    .run(function () { console.log("-- angular arx");

    });
} (window.jQuery, window.angular));

    // $('[target="appiframe"]')
    // .on('click', function (e) {
    //     e.preventDefault();

    //     var $el = $(this), href = $el.attr('href'), title = $el.attr('title');

    //     $el.parent().parent().find('.active').removeClass('active');
    //     $el.parent().addClass('active');

    //     $('[name="appiframe"]').attr('src', href);

    //     history.pushState({url: href}, title, '?url='+href);
    // });

    // if ($('.arx-container').length) {
    //     Util.resize(function () {
    //         var $bar = $('.arx-sidebar'), $content = $('.arx-content'), height = $(window).outerHeight();

    //         $content.attr('src', $content.attr('src'));

    //         if ($(window).outerWidth() > 980) {
    //             var barHeight = $bar.find('[data-spy="affix"]').outerHeight() || $content.outerHeight();

    //             $bar.css({minHeight: (barHeight < height ? height : barHeight)});
    //             $content.css({minHeight: height});
    //         } else {
    //             $bar.css({minHeight: 'none'});
    //             $content.css({minHeight: height});
    //         }
    //     });
    // }


    // $('.tooltip, [data-toggle="tooltip"]').tooltip();
    // $('.tooltip, [data-toggle="popover"]').popover();

    // $('[data-toggle="collapse"]')
    // .each(function () {
    //     var $el = $(this), target = $el.data('target') || $el.attr('href');

    //     $(target)
    //     .on('show.bs.collapse', function () {
    //         $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
    //         .closest('.panel')
    //         .addClass('active');
    //     })
    //     .on('hide.bs.collapse', function () {
    //         $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
    //         .closest('.panel')
    //         .removeClass('active');
    //     });
    // });

    // $('.collapse.in')
    // .each(function () {
    //     var target = '#' + $(this).attr('id');

    //     $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
    //     .closest('.panel')
    //     .addClass('active');
    // });


    // if ($('select.multiselect').length) {
    //     require(['multiselect'], function () {
    //         $('select.multiselect')
    //         .each(function () {
    //             var $el = $(this), datas = $el.data();

    //             $el.multiselect({
    //                 buttonClass: datas.buttonclass || '',
    //                 buttonWidth: 'auto',
    //                 buttonContainer: '<div class="btn-group"></div>',
    //                 maxHeight: false,
    //                 buttonText: function(options) {
    //                     if (options.length == 0) {
    //                         return 'None selected <span class="caret"></span>';
    //                     } else if (options.length > 3) {
    //                         return options.length + ' selected  <span class="caret"></span>';
    //                     } else {
    //                         var selected = '';

    //                         options.each(function() {
    //                             selected += $(this).text() + ', ';
    //                         });

    //                         return selected.substr(0, selected.length -2) + ' <span class="caret"></span>';
    //                     }
    //                 }
    //             });
    //         });
    //     });
    // }


    // // Externaliser Slidepanel /!\
    // $('.slidepanel.in').each(function () {console.log("ok");
    //     var $el = $(this);
    //     console.log($el.parent(), $el.outerWidth());
    //     $el.parent().css({marginLeft: $el.outerWidth()});
    // });

    // if (history.getState().data.url) {console.log(history.getState().data.url);
    //     $('[href="'+history.getState().data.url+'"').trigger('click');
    // }

    // $(window).trigger('resize');
    //
    //
    //
    //
    //
    //

// define(['angular'], function (angular) {
//     // require(['core']);
// });

// define('arx', [
//     'jquery',
//     'angular',
//     'history',
//     'bootstrap',
//     'angular-bootstrap'
// ], function ($, angular, history) {
//     if (typeof angular === 'undefined') {
//         angular = window.angular;
//     }

//     if (typeof history === 'undefined') {
//         history = window.History;
//     }

//     var app = angular.module('arx', []);

//     app
//     .run(function () { console.log('arx run!');

//         $(function () {
//             $('[target="appiframe"]')
//             .on('click', function (e) {
//                 e.preventDefault();

//                 var $el = $(this), href = $el.attr('href'), title = $el.attr('title');

//                 $el.parent().parent().find('.active').removeClass('active');
//                 $el.parent().addClass('active');

//                 $('[name="appiframe"]').attr('src', href);

//                 history.pushState({url: href}, title, '?url='+href);
//             });

//             if ($('.arx-container').length) {
//                 Util.resize(function () {
//                     var $bar = $('.arx-sidebar'), $content = $('.arx-content'), height = $(window).outerHeight();

//                     $content.attr('src', $content.attr('src'));

//                     if ($(window).outerWidth() > 980) {
//                         var barHeight = $bar.find('[data-spy="affix"]').outerHeight() || $content.outerHeight();

//                         $bar.css({minHeight: (barHeight < height ? height : barHeight)});
//                         $content.css({minHeight: height});
//                     } else {
//                         $bar.css({minHeight: 'none'});
//                         $content.css({minHeight: height});
//                     }
//                 });
//             }


//             $('.tooltip, [data-toggle="tooltip"]').tooltip();
//             $('.tooltip, [data-toggle="popover"]').popover();

//             $('[data-toggle="collapse"]')
//             .each(function () {
//                 var $el = $(this), target = $el.data('target') || $el.attr('href');

//                 $(target)
//                 .on('show.bs.collapse', function () {
//                     $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
//                     .closest('.panel')
//                     .addClass('active');
//                 })
//                 .on('hide.bs.collapse', function () {
//                     $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
//                     .closest('.panel')
//                     .removeClass('active');
//                 });
//             });

//             $('.collapse.in')
//             .each(function () {
//                 var target = '#' + $(this).attr('id');

//                 $('[data-toggle="collapse"][href="'+target+'"], [data-toggle="collapse"][data-target="'+target+'"]')
//                 .closest('.panel')
//                 .addClass('active');
//             });


//             if ($('select.multiselect').length) {
//                 require(['multiselect'], function () {
//                     $('select.multiselect')
//                     .each(function () {
//                         var $el = $(this), datas = $el.data();

//                         $el.multiselect({
//                             buttonClass: datas.buttonclass || '',
//                             buttonWidth: 'auto',
//                             buttonContainer: '<div class="btn-group"></div>',
//                             maxHeight: false,
//                             buttonText: function(options) {
//                                 if (options.length == 0) {
//                                     return 'None selected <span class="caret"></span>';
//                                 } else if (options.length > 3) {
//                                     return options.length + ' selected  <span class="caret"></span>';
//                                 } else {
//                                     var selected = '';

//                                     options.each(function() {
//                                         selected += $(this).text() + ', ';
//                                     });

//                                     return selected.substr(0, selected.length -2) + ' <span class="caret"></span>';
//                                 }
//                             }
//                         });
//                     });
//                 });
//             }


//             // Externaliser Slidepanel /!\
//             $('.slidepanel.in').each(function () {console.log("ok");
//                 var $el = $(this);
//                 console.log($el.parent(), $el.outerWidth());
//                 $el.parent().css({marginLeft: $el.outerWidth()});
//             });
//         });

//         $(window)
//         .on('load', function () {
//             if (history.getState().data.url) {console.log(history.getState().data.url);
//                 $('[href="'+history.getState().data.url+'"').trigger('click');
//             }

//             $(window).trigger('resize');
//         });

//     });

// });

// require(['arx']);
