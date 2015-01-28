module.exports = function (grunt) {
    'use strict';

    var taskConfig = {
        // Metadata
        pkg: grunt.file.readJSON('package.json'),
        bowerrc: grunt.file.readJSON('.bowerrc'),

        // Variables
        src: 'app/_assets', // src packages
        dist: 'public/assets', // Change this to publish where you want !
        packages: 'public/packages',// Change the packages repository to suit your needs

        main_files: {
            sass: [],
            less: [],
            uglify: [],
            fonts: []
        },

        plugins_files: {
            concat_css: [],
            concat_js: [],
            copy_fonts: [],
            copy_img: [],
            copy_media: []
        },

        // Javascript compiler
        uglify: {
            options: {
                compress: false
            },

            // Main
            main: {
                files: {
                    '<%= dist %>/js/main.js': '<%= main_files.uglify %>'
                }
            } // main JS

        }, // uglify

        // Less Compiler
        less: {

            // Main
            main: {
                options: {
                    separator: '\n',
                    compress: true
                },
                files: {
                    '<%= dist %>/css/main.css': '<%= main_files.less %>'
                }
            } // main

        }, // less

        // Sass Compiler
        sass: {

            // Main
            main: {
                options: {
                    separator: '\n',
                    compress: true
                },
                files: {
                    '<%= dist %>/css/main.css': '<%= main_files.sass %>'
                }
            } // main
        }, // sass

        // Plugins concatenations

        concat: {

            // main plugins

            main_plugins_js: {
                options: {
                    separator: ';\n',
                    stripBanners: true
                },
                src: '<%= plugins_files.concat_js %>',
                dest: '<%= dist %>/js/main-plugins.js'
            },

            main_plugins_css: {
                options: {
                    separator: ';\n',
                    stripBanners: true
                },
                src: '<%= plugins_files.concat_css %>',
                dest: '<%= dist %>/css/main-plugins.css'
            },

            // Main combine

            main_combined_css: {
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

            main_combined_js: {
                options: {
                    separator: '\n',
                    stripBanners: true
                },
                src: [
                    '<%= dist %>/js/main-plugins.js',
                    '<%= dist %>/js/main.js'
                ],
                dest: '<%= dist %>/css/main-combined.css'
            }
        }, // concat

        copy: {
            plugins: {
                files: [{
                    expand: true,
                    src: '<%= plugins_files.copy_img %>',
                    dest: '<%= dist %>/img',
                    filter: 'isFile'
                },
                {
                    expand: true,
                    src: '<%= plugins_files.copy_fonts %>',
                    dest: '<%= dist %>/fonts',
                    filter: 'isFile'
                },
                {
                    expand: true,
                    src: '<%= plugins_files.copy_media %>',
                    dest: '<%= dist %>/media',
                    filter: 'isFile'
                }]
            }
        },

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

            sass: {
                files: [
                    '<%= src %>/scss/*.scss'
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
                    'app/*.php',
                    'Grunt.js',
                    'app/**/*.php',
                    'public/**/*.js',
                    'app/**/*.css',
                    'workbench/**/*.php'
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
        'sass',
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


    grunt.event.on('watch', function (action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });
};