module.exports = function (grunt) {
    'use strict';

    var taskConfig = {
        // Metadata
        pkg: grunt.file.readJSON('package.json'),
        bowerrc: grunt.file.readJSON('.bowerrc'),

        // Variables
        src: 'app/_assets', // src packages
        dist: 'public/assets', // Change this to publish where you want !
        packages : 'public/packages', // Change the packages repository to suit your needs

        // Javascript compiler
        uglify: {
            options: {
                compress: false
            },

            // Main
            main : {
                files: {
                    '<%= dist %>/js/main.js' : [
                        "<%= dist %>/assets/main.js"
                    ]
                }
            }, // main JS

            // Admin
            admin : {
                files: {
                    '<%= dist %>/js/admin.js' : [
                        "<%= src %>/js/admin.js"
                    ]
                }
            } // admin JS
        }, // uglify

        // Less Compiler
        less: {

            // Main
            main : {
                options: {
                    separator: '\n',
                    compress: true
                },
                files: {
                    '<%= dist %>/css/main.css': [
                        "<%= src %>/less/main.less"
                    ]
                }
            }, // main

            // Admin
            admin : {
                options: {
                    separator: '\n',
                    compress: true
                },
                files: {
                    '<%= dist %>/css/admin.css': [
                        "<%= src %>/less/admin.less"
                    ]
                }
            } // admin
        }, // less

        // Plugins concatainer

        concat: {

            // Main Concat

            // main plugins

            main_plugins_js : {
                options: {
                    separator: ';\n',
                    stripBanners: true
                },
                src: [
                    // plugins goes here
                ],
                dest: '<%= dist %>/js/main-plugins.js'
            },

            main_plugins_css : {
                options: {
                    separator: ';\n',
                    stripBanners: true
                },
                src: [
                    // plugins goes here
                ],
                dest: '<%= dist %>/css/main-plugins.css'
            },

            // Main combine

            main_combined_css : {
                options: {
                    separator: '\n',
                    stripBanners: true
                },
                src: [
                    '<%= dist %>/css/main-plugins.css',
                    '<%= dist %>/css/main.css'
                ],
                dest: '<%= dist %>/css/main-combined.css'
            },

            main_combined_js : {
                options: {
                    separator: '\n',
                    stripBanners: true
                },
                src: [
                    '<%= dist %>/js/main-plugins.js',
                    '<%= dist %>/js/main.js'
                ],
                dest: '<%= dist %>/css/main-combined.css'
            },

            // Admin Concatenation


            // Admin Plugins

            admin_plugins_js : {
                options: {
                    separator: ';\n',
                    stripBanners: false
                },
                src: [
                    //'public/packages/jquery/jquery.js',
                    //'public/packages/angular/angular.js',
                    //'public/packages/bootstrap/dist/js/bootstrap.min.js',

                    'public/packages/arx/core/dist/js/arx-combined.js',
                    'public/packages/datatables/media/js/jquery.dataTables.js',
                    'public/packages/angular-bootstrap/ui-bootstrap.min.js',
                    'public/packages/angular-bootstrap/ui-bootstrap-tpls.min.js',
                    'public/packages/angular-validator/dist/angular-validator.js',
                    'public/packages/angular-validator/dist/angular-validator-rules.js',
                    'public/packages/angular-form-builder/dist/angular-form-builder.js',
                    'public/packages/angular-form-builder/dist/angular-form-builder-components.js'
                ],
                dest: '<%= dist %>/js/admin-plugins.js'
            },

            admin_plugins_css : {
                options: {
                    separator: ';\n',
                    stripBanners: true
                },
                src: [
                    // plugins goes here
                    '<%= packages %>/arxmin/dist/css/arxmin-combined.css',
                    'public/packages/angular-form-builder/dist/angular-form-builder.css'
                ],
                dest: '<%= dist %>/css/admin-plugins.css'
            },

            // Admin Combine

            admin_combined_css : {
                options: {
                    separator: '\n',
                    stripBanners: true
                },
                src: [
                    '<%= dist %>/css/admin-plugins.css',
                    '<%= dist %>/css/admin.css'
                ],
                dest: '<%= dist %>/css/admin-combined.css'
            },

            admin_combined_js : {
                options: {
                    separator: '\n',
                    stripBanners: true
                },
                src: [
                    '<%= dist %>/js/admin-plugins.js',
                    '<%= dist %>/js/admin.js'
                ],
                dest: '<%= dist %>/js/admin-combined.js'
            }
        }, // concat

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'Gruntfile.js',
                '<%= src %>/js*//*.js'
            ]
        }, // jshint

        watch: {
            less: {
                files: [
                    '<%= src %>/less/*.less'
                ],

                tasks: [
                    'css'
                ]
            },

            // Watch
            js: {
                files: [
                    '<%= jshint.all %>'
                ],

                tasks: ['js']
            },

            // Everything in that should trigger LiveReload

            livereload: {
                options: {
                    livereload: true
                },
                files: [
                    'app/*.js',
                    'app/*.less',
                    'app/*.php',
                    'Grunt.js',
                    'app/*/*.php',
                    'app/views/*.php'
                ]
            }
        }, // watch

        shell: {
            done: {
                command: 'terminal-notifier -message "Bazinga! Grunt tasks done!" -title "Gruntfile.js" -sound Pop'
            }
        }, // shell


        connect: {
            server: {
                options: {
                    port: 8870,
                    base: '.'
                }
            }
        } // connect
    };


    grunt.initConfig(grunt.util._.extend(taskConfig));


    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);


    /**
     * Only CSS
     */
    grunt.registerTask('css', [
        'less',
        'shell:done'
    ]);

    /**
     * Only JS
     */
    grunt.registerTask('js', [
        'uglify',
        'concat',
        'shell:done'
    ]);

    /**
     * The default task is to build and compile.
     */
    grunt.registerTask('default', [
        'css',
        'js'
    ]);


    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });

};