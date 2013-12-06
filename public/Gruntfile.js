'use strict';

module.exports = function(grunt) {

    grunt.initConfig({
        // Metadata
        pkg: grunt.file.readJSON('package.json'),


        // -- Tasks
        clean: {
            dist: [
                'dist/css/arx.css',
                'dist/js/arx.js'
            ]
        }, // clean

        recess: {
            arx: {
                options: {
                    compile: true,
                    compress: true
                },
                files: {
                    'dist/css/arx.css': [
                        'src/less/arx.less'
                    ]
                }
            }, // arx

            arxcombined: {
                options: {
                    compile: true,
                    compress: true
                },
                files: {
                    'dist/css/arx-combined.css': [
                        'src/less/plugins.less',
                        'src/less/arx-combined.less'
                    ]
                }
            } // arxcombined
        },

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'Gruntfile.js',
                'src/js/*.js',
                '!dist/js/*.min.js'
            ]
        }, // jshint

        uglify: {
            arx: {
                options: {
                    banner: ''
                },
                files: {
                    'dist/js/arx.js': [
                        'src/js/arx.js'
                    ]
                }
            }, // arx

            arxcombined: {
                options: {
                    banner: ''
                },
                files: {
                    'dist/js/arx-combined.js': [
                        '../jquery/jquery.min.js',
                        '../history.js/scripts/bundled/html4+html5/jquery.history.js',
                        '../jquery-ui/ui/jquery-ui.js',
                        '../bootstrap/dist/js/bootstrap.min.js',
                        '../bootstrap-multiselect/js/bootstrap-multiselect.js',
                        '../select2/select2.min.js',
                        '../datatables/media/js/jquery.dataTables.js',
                        // '../datatables-tabletools/media/js/ZeroClipboard.js',
                        // '../datatables-tabletools/media/js/TableTools.js',

                        '../angular/angular.min.js',
                        '../angular-ui-utils/modules/event/event.js',
                        '../angular-ui-utils/modules/format/format.js',
                        '../angular-ui-utils/modules/highlight/highlight.js',
                        '../angular-ui-utils/modules/ie-shiv/ie-shiv.js',
                        '../angular-ui-utils/modules/indeterminate/indeterminate.js',
                        '../angular-ui-utils/modules/inflector/inflector.js',
                        '../angular-ui-utils/modules/jq/jq.js',
                        '../angular-ui-utils/modules/keypress/keypress.js',
                        '../angular-ui-utils/modules/mask/mask.js',
                        '../angular-ui-utils/modules/reset/reset.js',
                        '../angular-ui-utils/modules/route/route.js',
                        '../angular-ui-utils/modules/scrollfix/scrollfix.js',
                        '../angular-ui-utils/modules/showhide/showhide.js',
                        '../angular-ui-utils/modules/unique/unique.js',
                        '../angular-ui-utils/modules/validate/validate.js',
                        '../angular-ui-utils/modules/utils.js',
                        '../angular-bootstrap/ui-bootstrap-tpls.min.js',

                        // '../jquery-pageslide/jquery.pageslide.min.js',

                        'src/js/utils.js',
                        'src/js/arx.js'
                    ]
                }
            }, // arxcombined
        }, // uglify


        shell: {
            done: {
                command: 'terminal-notifier -message "Tasks done!" -title "Gruntfile.js"'
            }
        }, // shell

        connect: {
            server: {
                options: {
                    port: 8800,
                    base: '.'
                }
            }
        }, // connect

        watch: {
            less: {
                  files: [
                        'src/less/*.less'
                  ],

                  tasks: ['recess', 'shell:done']
            },

            js: {
                  files: [
                    '<%= jshint.all %>'
                  ],

                  tasks: [/*'jshint',*/ 'uglify', 'shell:done']
            }
        }, // watch
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    // grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-recess');
    grunt.loadNpmTasks('grunt-shell');


    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });


    // -- Tasks

    grunt.registerTask('before-test', [
        'clean'
    ]);
    grunt.registerTask('test', [
        'recess',
        'uglify'
    ]);
    grunt.registerTask('after-test', [
        'shell:done'
    ]);

    grunt.registerTask('js', [
        'uglify',
        'shell:done'
    ]);
    grunt.registerTask('css', [
        'recess',
        'shell:done'
    ]);

    grunt.registerTask('default', ['before-test', 'test', 'after-test']);
};
