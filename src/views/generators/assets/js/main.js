'use strict';

// required external components
import angular from 'angular';
import $ from 'jquery';

// required utils components
import Debug from './lib/debug';
import './lib/helpers';

// required project specific components
// @components_injection_start

// @components_injection_end

// defaults modules
let dependencies = ['ui.router', 'pascalprecht.translate'];

// expose Debug class
window.Debug = Debug;

/**
 * Modules (`$.modules`) are used with the DOM routing
 */
$.modules = {
    'common': () => {
        // preload
        $(document.body).addClass('loading');

        // inform Google Analytics of the change
        if (typeof window.ga !== 'undefined') {
            let tracked = document.location.href.replace(document.location.origin, '');
            window.ga('send', 'pageview', tracked);
        }

        return {
            isInitialized: false,

            load() {
                // ensure to execute common function once
                if (!this.isInitialized) {
                    Debug.bench('common:load');
                    this.isInitialized = true;
                }
            },

            finalize() {
                angular.module('app', dependencies);

                // bootstrap the app (async)
                angular.bootstrap(document, ['app']);

                setTimeout(function () {
                    $(document.body).removeClass('loading');
                }, 0);

                Debug.bench('common:finalize', true);
            }
        };
    },

    'tpl_home': () => {
        return {
            load() {
                Debug.bench('tpl_page_home:load');
                //dependencies.push('home');
            }
        };
    },
};


$(document).ready(() => {
    $.fire('common');

    $.loadEvents($(document.body).attr('class'), (classnm) => {
        $.fire(classnm);
    });

    $.fire('common', 'finalize');
});