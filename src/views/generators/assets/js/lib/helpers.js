'use strict';

import $ from 'jquery';

/* jshint ignore: start */
(function() {
    // Quickie PubSub
    let o = $({});

    $.subscribe = () => { o.on.apply(o, arguments); };
    $.publish = () => { o.trigger.apply(o, arguments); };

    // Async submit a form's input.
    function handleFormRequest(e) {
        e.preventDefault();

        let form = $(this);
        let method = form.find('input[name="_method"]').val() || 'POST';

        form.find('[data-ajax-undefined]').addClass('hide');
        form.find('[data-ajax-error]').addClass('hide');
        form.find('[data-ajax-progress]').removeClass('hide');

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: () => {
                form.find('[data-ajax-error]').addClass('hide');
                form.find('[data-ajax-success]').removeClass('hide');
                form.find('[data-ajax-progress]').addClass('hide');

                $.publish('ajax.request.success', form);
            },
            error : () => {
                form.find('[data-ajax-error]').removeClass('hide');
                form.find('[data-ajax-success]').addClass('hide');
                form.find('[data-ajax-undefined]').addClass('hide');
                form.find('[data-ajax-progress]').addClass('hide');

                $.publish('ajax.request.error', form);
            }
        });
    }


    // Handle success callbacks. To trigger Task.foo(), do:
    // 'data-model' => 'Task', 'data-remote-on-success' => 'foo'
    $.subscribe('ajax.request.success', (e, form) => {
        triggerClickCallback.apply(form, [e, $(form).data('remote-on-success')]);
    });


    // Confirm an action before proceeding.
    function confirmAction(e) {
        let input = $(this);

        input.prop('disabled', 'disabled');

        // Or, much better, use a dedicated modal.
        if ( !confirm(input.data('confirm'))) {
            e.preventDefault();
        }

        input.removeAttr('disabled');
    }

    // Trigger the registered callback for a click or form submission.
    function triggerClickCallback(e, method) {
        e.preventDefault();

        let that = $(this);
        let model;

        // What's the name of the parent model/scope/object.
        if ( !(model = that.closest('*[data-model]').data('model'))) {
            return;
        }

        // As long as the object and method exist, trigger it and pass through the form.
        if (typeof window[model] === 'object' && typeof window[model][method] === 'function') {
            window[model][method](that);
        } else {
            console.error('Could not call method ' + method + ' on object ' + model);
        }
    }

    if (typeof window._no_autobinding === 'undefined') {
        $('form[data-ajax]').on('submit', handleFormRequest);

        $('input[data-confirm], button[data-confirm]').on('click', confirmAction);

        $('*[data-click]').on('click', (e) => {
            triggerClickCallback.apply(this, [e, $(this).data('click')]);
        });
    }
}) ();
/* jshint ignore: end */


export default $.extend({
    /**
     * Fire a module from "$.modules".
     * Return false if "func" or "funcname" was not found.
     *
     * @param func
     * @param funcname
     * @param args
     * @returns {boolean}
     */
    fire(func, funcname, args) {
        let fire;
        let namespace = $.modules;

        funcname = (funcname === undefined) ? 'load' : funcname;

        fire = func !== '';
        fire = fire && namespace[func];

        if (typeof namespace[func] === 'function') {
            namespace[func] = namespace[func]();
        }

        fire = fire && typeof namespace[func][funcname] === 'function';

        if (fire) {
            namespace[func][funcname](args);

            return true;
        }

        return false;
    },

    /**
     * Load events from "classnm".
     *
     * @param classname
     * @param callback
     */
    loadEvents(classname = '', callback = null) {
        $.each(classname.replace(/-/g, '_').split(/\s+/), (i, classnm) => { callback && callback(classnm); });
    }
});
