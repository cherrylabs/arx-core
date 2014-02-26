'use strict';

module.exports = function(grunt) {

    grunt.initConfig({
        // Metadata
        pkg: grunt.file.readJSON('package.json'),


        // -- Tasks
        clean: {
            dist: [

            ]
        }, // clean

        recess: {
            arx: {
                options: {
                    compile: true,
                    compress: true
                },
                files: {
                    '../../../../public/packages/arx/core/dist/css/arx.css': [
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
                    '../../../../public/packages/arx/core/dist/css/arx-combined.css': [
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
                    '../../../../public/packages/arx/core/dist/js/arx.js': [
                        'src/js/arx.js'
                    ]
                }
            }, // arx

            arxcombined: {
                options: {
                    banner: ''
                },
                files: {
                    '../../../../public/packages/arx/core/dist/js/arx-combined.js': [
                        '../../../../public/packages/jquery/jquery.min.js',
                        '../../../../public/packages/jquery-ui/ui/jquery-ui.js',
                        '../../../../public/packages/bootstrap/dist/js/bootstrap.min.js',
                        '../../../../public/packages/angular/angular.min.js',
                        '../../../../public/packages/angular-sanitize/angular-sanitize.min.js',
                        '../../../../public/packages/bootstrap-multiselect/js/bootstrap-multiselect.js',
                        '../../../../public/packages/select2/select2.min.js',
                        '../../../../public/packages/datatables/media/js/jquery.dataTables.js',
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
