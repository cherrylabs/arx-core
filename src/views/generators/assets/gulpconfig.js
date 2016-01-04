/* jshint ignore: start */
var path = require('path');
var webpack = require('webpack');

module.exports = {

    /**
     * Paths
     */
    dir: {
        dist:       'public/assets',
        src:        'resources/assets',
        pkg:        'bower_components',
        views:      'resources/views',
    },

    /**
     * Files
     *
     * @example
     * folder: {
     *  'filename': 'path/to/file' // or []
     * }
     */
    files: {
        'css': {
            'main.css': '<%= dir.src %>/scss/main.scss',
        },
        'js': {
            'plugins.js': [
                '<%= dir.pkg %>/angular-translate/angular-translate.js',
            ]
        },
        'webpack': {
            'main.js': [
                '<%= dir.src %>/js/main.js',
            ]
        },
        'html': [
            '<%= dir.src %>/html/*.html'
        ]
    },

    /**
     * Copy
     */
    copy: {
        'js/vendor': [
            '<%= dir.pkg %>/jquery/dist/jquery.min.js',
            '<%= dir.pkg %>/jquery/dist/jquery.min.map',
            '<%= dir.pkg %>/jquery-migrate/jquery-migrate.min.js',
            '<%= dir.pkg %>/angular/angular.js',
        ],
        'fonts': [
            '<%= dir.src %>/fonts/*',
            '<%= dir.pkg %>/font-awesome/fonts/*',
        ],
    },

    /**
     * Files to watch
     */
    watch: {
        scss:       '<%= dir.src %>/scss/**/*.scss',
        js:         '<%= dir.src %>/js/**/*.js',
        img:        '<%= dir.src %>/img/**/*',
        html:       '<%= dir.src %>/html/**/*.html',
    },

    /**
     * Server configuration
     */
    server: {
        base:           'public',
        hostname:       '127.0.0.1',
        port:           9000,
        livereload:     false,
        watch:          false,
    },

    /**
     * Plugins Gulp
     */
    // @see https://github.com/ai/autoprefixer
    autoprefixer: [
        'ie >= 9',
        'ie_mob >= 10',
        'ff >= 30',
        'chrome >= 34',
        'safari >= 7',
        'opera >= 23',
        'ios >= 7',
        'android >= 4.4',
        'bb >= 10',
    ],

    babel: {},

    livereload: [
        'app/**/*.php',
        '<%= dir.views %>/**/*.php',
        '<%= dir.dist %>/css/*.css',
        '<%= dir.dist %>/js/*.js',
        '<%= dir.dist %>/html/*.html',
    ],

    imagemin: {
        optimizationLevel: 5,
        progressive: true,
        interlaced: true,
        svgoPlugins: [{ removeUnknownsAndDefaults: false }]
    },

    // @see https://www.npmjs.com/package/gulp-minify-html
    minifyhtml: {
        comments: false,
        conditionals: true,
        spare: false,
        empty: true
    },

    jshint: {
        browser:        true,
        camelcase:      false,
        curly:          true,
        devel:          true,
        eqeqeq:         false,
        esnext:         true,
        expr:           true,
        freeze:         false,
        globals:        {
            angular: true
        },
        globalstrict:   true,
        jquery:         true,
        latedef:        false,
        newcap:         true,
        nonbsp:         true,
        strict:         true,
        undef:          true,
        unused:         false
    },

    webpack: {
        resolve: {
            extensions: ['', '.js'],
            root: [
                path.resolve('./src/js'),
                path.join(__dirname, 'bower_components')
            ]
        },
        plugins: [
            new webpack.ResolverPlugin(
                new webpack.ResolverPlugin.DirectoryDescriptionFilePlugin('bower.json', ['main'])
            ),
            new webpack.ProvidePlugin({
                $: 'jquery'
            })
        ],
        externals: {
            angular: 'angular',
            jquery: 'jQuery'
        },
        module: {
            loaders: [
                { test: /jquery\.js$/, loader: 'expose?jQuery!expose?$' },
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components|plugins)/,
                    // @see https://github.com/babel/babel-loader#options
                    loaders: [
                        'ng-annotate?' + JSON.stringify({
                            add: true,
                            single_quotes: true
                        }),
                        'babel?' + JSON.stringify({
                            cacheDirectory: true,
                            optional: ['runtime'],
                            stage: 0
                        })
                    ]
                }
            ]
        }
    }
};
