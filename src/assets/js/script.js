/**
 * Cabaret
 * JS File - /arx/assets/js/script.js
 */

(function ($) {
    'use strict';


    $(function () {
        // init tooltips on .tips class elements, text for the tooltip is in the data-title attribute on the element itself
        $('.tip').tooltip();

        // init popover on .pop class elements
        $('.pop').popover({
            title: $(this).data('title'),
            content: $(this).data('content'),
            placement: 'top'
        });

        // init datepicker
        $('.datepicker-basic').datepicker();
        $('#datepicker-years').datepicker({viewMode: 2});

        // init typehead (auto-complete)
        $('.typeahead').typeahead();

        // collapse function for the widget
        $('.widget-buttons a.collapse').click(function (e) {
            e.preventDefault();

            if ($(this).attr('data-collapsed') == 'false') {
                $(this).closest('.widget').find('.widget-body').slideUp().parent().addClass('collapsed');
                $(this).attr('data-collapsed', 'true').addClass('widget-hidden');
            } else {
                $(this).closest('.widget').find('.widget-body').slideDown().parent().removeClass('collapsed');
                $(this).attr('data-collapsed', 'false').removeClass('widget-hidden');
            }
        });
    });
} (jQuery));