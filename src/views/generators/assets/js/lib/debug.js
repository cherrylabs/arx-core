'use strict';

let instance = null;

/**
 * Debug class
 *
 * @class Singleton
 */
class Debug {
    constructor() {
        if (!instance) {
            instance = this;
        }

        this.options = {
            debug: window.debug
        };

        this._benchmarks = {};
        this._time = new Date().getTime();

        this.bench('start');

        return instance;
    }

    /**
     * Save the current time to permit basic benchmark
     */
    bench(name, display) {
        let time = new Date().getTime() - this._time;

        this._benchmarks[time + 'ms'] = name;

        display && this.log('Bench: ', this._benchmarks);
    }

    /**
     * Wrapper around console.debug falling to console.log
     */
    log() {
        if (!this.options.debug) {
            return;
        }

        // try to use 'debug' instead of 'log'
        // @todo Check IE9+
        (console.debug || console.info || console.log).apply(window.console, arguments);
    }

    /**
     * Allow to toggle body.debug from the console
     */
    toggle() {
        $(document.body).toggleClass('debug');
    }
}

export default new Debug();
