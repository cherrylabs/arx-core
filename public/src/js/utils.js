var Util = {
    load: function (callback) {
        callback();
        $(window).on('load', callback);
    }, // load

    resize: function (callback) {
        callback();
        $(window).on('resize', callback);
    } // resize
}; // Util
