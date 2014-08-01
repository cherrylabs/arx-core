'use strict';

module.exports = function (grunt) {

    grunt.initConfig({

        // -- Get infos from bower and npm packages

        pkg: grunt.file.readJSON('package.json'),
        bower: grunt.file.readJSON('bower.json'),
        bowerrc: grunt.file.readJSON('.bowerrc'),

        // -- Variables

        src: 'src', // src packages
        dist: 'dist', // Change this to publish where you want !
        packages: '<%= bowerrc.directory %>', // Change the packages repository to suit your needs

        // -- Tasks

        // # Copy files and folders.
        copy: {
            fontawesome: {
                expand : true,
                cwd: '<%= packages %>/fontawesome/fonts/',
                src: "*",
                dest: '<%= dist %>/fonts/'
            },

            bootstrap : {
                expand : true,
                cwd: '<%= packages %>/bootstrap/fonts/',
                src: "*",
                dest: '<%= dist %>/fonts/'
            }
        },

        // Concatenates plugins files

        concat: {

            pluginscss: {
                options: {
                    stripBanners: true,
                    banner: '/* Plugins <%= pkg.name %> - v<%= pkg.version %> */'
                },
                src: [
                    '<%= packages %>/bootstrap/dist/css/bootstrap.css',
                    '<%= packages %>/fontawesome/css/font-awesome.css',
                ],
                dest: '<%= dist %>/css/plugins.css'
            },

            pluginsjs: {
                options: {
                    stripBanners: true,
                    banner: '/* <%= pkg.name %> - v<%= pkg.version %> */'
                },
                src: [
                    '<%= packages %>/jquery/jquery.js',
                    '<%= packages %>/angular/angular.js',
                    '<%= packages %>/angular-animate/angular-animate.js',
                    '<%= packages %>/bootstrap/dist/bootstrap.js',
                    '<%= packages %>/angular-bootstrap/ui-bootstrap.min.js',
                    '<%= packages %>/angular-bootstrap/ui-bootstrap-tpls.min.js',
                    '<%= packages %>/angular-ui-utils/ui-utils.min.js',
                    '<%= packages %>/spinjs/spin.js',
                    '<%= packages %>/spinjs/jquery.spin.js'
                ],
                dest: '<%= dist %>/js/plugins.js'
            },

            plugin_notify : {
                src: [
                    '<%= packages %>/humane/humane.min.js',
                    '<%= src %>/plugin/notify/notify.js'
                ],
                dest: '<%= dist %>/plugin/notify/notify.js'
            }
        },

        // -- Less compiler
        less: {
            // compile Arx CSS
            arx: {
                options: {
                    compile: true,
                    compress: false
                },
                files: {
                    '<%= dist %>/css/arx.css': [
                        '<%= src %>/less/arx.less',
                        '<%= src %>/less/theme.less',
                        '<%= src %>/less/plugins.less'
                    ]
                }
            },
            arx_min: {
                options: {
                    compile: true,
                    compress: true,
                    sourceMap : true
                },
                files: {
                    '<%= dist %>/css/arx.min.css': [
                        '<%= src %>/less/arx.less',
                        '<%= src %>/less/theme.less',
                        '<%= src %>/less/plugins.less'
                    ]
                }
            },

            plugins : {
                options: {
                    compile: true,
                    compress: false
                },
                files: {
                    '<%= dist %>/plugin/tree/tree.css': [
                        '<%= src %>/plugin/tree/tree.less'
                    ],
                }
            }, // arx

            plugins_min : {
                options: {
                    compile: true,
                    compress: true,
                    sourceMap : true
                },
                files: {
                    '<%= dist %>/plugin/tree/tree.min.css': [
                        '<%= src %>/plugin/tree/tree.less'
                    ]
                }
            }, // plugins_min



            plugin_notify : {
                options: {
                    compile: true,
                    compress: true,
                    sourceMap : true
                },
                files: {
                    '<%= dist %>/plugin/notify/notify.css': [
                        '<%= src %>/plugin/notify/notify.less'
                    ]
                }
            }, // plugins_min
        },

        /**
         * Check JS code
         */

        uglify: {
            arx: {
                options: {
                    banner: '/* ARX.JS v.<%= bower.version %> */',
                    beautify : true

                },
                files : {
                    '<%= dist %>/js/arx.js': [
                        '<%= dist %>/js/arx.js'
                    ]
                }
            },
            arx_min: {
                options: {
                    banner: '/* ARX.JS v.<%= bower.version %> */'

                },
                files: {
                    '<%= dist %>/js/arx.min.js': [
                        '<%= dist %>/js/arx.js'
                    ]
                }
            }, // arx

            utils_min : {
                options: {
                    banner: ''

                },
                files: [{
                    expand: true,
                    cwd: '<%= src %>/js/utils',
                    src: '*.js',
                    dest: '<%= dist %>/js/utils'
                }]
            } // utils
        }, // uglify

        concat_sourcemap: {
            options: {
                // Task-specific options go here.
            },
            target: {
                files: {
                    '<%= dist %>/css/arx-combined.css': [
                        '<%= dist %>/css/plugins.css',
                        '<%= dist %>/css/arx.css'
                    ],
                    '<%= dist %>/js/arx-combined.js': [
                        '<%= dist %>/js/plugins.js',
                        '<%= dist %>/js/arx.js'
                    ]
                }
            }
        },

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'Gruntfile.js',
                '<%= src %>/js/*.js',
                '!dist/js/*.min.js'
            ]
        }, // jshint


        // Clean files and folders
        clean: {

        },
        // clean

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
                    '<%= src %>/less/*.less',
                    '<%= src %>/**/*.less'
                ],
                tasks: ['css', 'shell:done']
            },
            js: {
                files: [
                    '<%= jshint.all %>',
                    '<%= src %>/**.js'
                ],
                tasks: ['js', 'shell:done']
            },
            compile : {
                files: [
                    '<%= src %>/less/*.less',
                    '<%= src %>/**/*.less'
                ],
                tasks: ['compile', 'shell:done']
            },
            livereload: {
                options: {
                    livereload: true
                },
                files: [
                    'example/**',
                    '<?= dist ?>/*',
                ]
            }
        } // watch
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-concat-sourcemap');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-shell');


    grunt.event.on('watch', function (action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });


    // -- Tasks

    grunt.registerTask('test', [
        //'clean'
    ]);

    grunt.registerTask('js', [
        'copy',
        'concat',
        'uglify',
        'concat_sourcemap'
    ]);

    grunt.registerTask('css', [
        'less',
        'concat_sourcemap'
    ]);

    grunt.registerTask('compile', [
        'copy',
        'concat',
        'css',
        'js'
    ]);

    grunt.registerTask('check', [
        'shell:done'
    ]);

    grunt.registerTask('default', ['test', 'compile', 'check']);

    grunt.registerTask('dev', ['test', 'compile', 'check', 'watch']);
};
