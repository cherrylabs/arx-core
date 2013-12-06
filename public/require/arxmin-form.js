/**
 * Require.js Config for Arxmin
 *
 * @author : Daniel Sum <daniel@cherrypulp.com>
 * @todo : watch for angular 1.2 release
 */

requirejs.config({
    "paths": {
        "jquery": "//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min",
        "bootstrap": "//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min",
        "angular": "//ajax.googleapis.com/ajax/libs/angularjs/1.2.0-rc.3/angular.min"
    }
});

require(["jquery"], function(){});

require([
    "../../history.js/scripts/compressed/history.adapter.jquery",
    "bootstrap"
]);

require([
    "../../bootstrap-multiselect/js/bootstrap-multiselect",
    "../../select2/select2.min",
    "../../jquery-ui/ui/jquery-ui",
    "../dist/js/arx.min"
]);