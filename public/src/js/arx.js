/**
 * ARX JS CLASS
 */
(function() {
    var Arx = Class.create({
        init: function () {
            this.version = "1.0";
            this.instance = null;
        },
        getInstance: function () {
            if (instance == null) {
                instance = new constructeur();
                instance.constructeur = null;
            }

            return instance;
        },
        isFunction: function (object) {
            return object && getClass.call(object) == '[object Function]';
        }
    });

    window.Arx = Arx.getInstance() || {};
});