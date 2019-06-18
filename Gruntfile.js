module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        modx: grunt.file.readJSON('_build/config.json'),
        banner: '/*!\n' +
            ' * <%= modx.name %> - <%= modx.description %>\n' +
            ' * Version: <%= modx.version %>\n' +
            ' * Build date: <%= grunt.template.today("yyyy-mm-dd") %>\n' +
            ' */\n',
        usebanner: {
            css: {
                options: {
                    position: 'bottom',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/imageplus/css/mgr/imageplus.min.css'
                    ]
                }
            },
            js: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/imageplus/js/mgr/imageplus.min.js'
                    ]
                }
            }
        },
        uglify: {
            mgr: {
                src: [
                    'source/js/mgr/imageplus.js',
                    'source/js/mgr/imageplus.panel.input.js',
                    'source/js/mgr/imageplus.window.editor.js',
                    'source/js/mgr/imageplus.migx_renderer.js',
                    'source/js/mgr/tools/JSON2.js',
                    'node_modules/jquery/dist/jquery.slim.min.js',
                    'source/js/mgr/jcrop/jquery.jcrop.min.js',
                    'source/js/mgr/imageplus.jquery.imagecrop.js',
                    'source/js/mgr/imageplus.grid.js'
                ],
                dest: 'assets/components/imageplus/js/mgr/imageplus.min.js'
            }
        },
        sass: {
            options: {
                implementation: require('node-sass'),
                outputStyle: 'expanded',
                sourcemap: false
            },
            mgr: {
                files: {
                    'source/css/mgr/imageplus.css': 'source/sass/mgr/imageplus.scss'
                }
            }
        },
        postcss: {
            options: {
                processors: [
                    require('pixrem')(),
                    require('autoprefixer')()
                ]
            },
            mgr: {
                src: [
                    'source/css/mgr/imageplus.css'
                ]
            }
        },
        cssmin: {
            mgr: {
                src: [
                    'source/css/mgr/imageplus.css',
                    'source/css/mgr/jquery.jcrop.min.css'
                ],
                dest: 'assets/components/imageplus/css/mgr/imageplus.min.css'
            }
        },
        imagemin: {
            png: {
                options: {
                    optimizationLevel: 7
                },
                files: [
                    {
                        expand: true,
                        cwd: 'source/img/mgr/',
                        src: ['**/*.png'],
                        dest: 'assets/components/imageplus/img/mgr/',
                        ext: '.png'
                    }
                ]
            },
            gif: {
                files: [
                    {
                        expand: true,
                        cwd: 'source/img/mgr/',
                        src: ['**/*.gif'],
                        dest: 'assets/components/imageplus/img/mgr/',
                        ext: '.gif'
                    }
                ]
            }
        },
        watch: {
            js: {
                files: [
                    'source/**/*.js'
                ],
                tasks: ['uglify', 'usebanner:js']
            },
            css: {
                files: [
                    'source/**/*.scss'
                ],
                tasks: ['sass', 'postcss', 'cssmin', 'usebanner:css']
            },
            config: {
                files: [
                    '_build/config.json'
                ],
                tasks: ['default']
            }
        },
        bump: {
            copyright: {
                files: [{
                    src: 'core/components/imageplus/**/*.php',
                    dest: 'core/components/imageplus/'
                }, {
                    src: 'source/js/mgr/**/*.js',
                    dest: 'source/js/mgr/'
                }],
                options: {
                    replacements: [{
                        pattern: /Copyright 2015(-\d{4})? by/g,
                        replacement: 'Copyright ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear() + ' by'
                    }, {
                        pattern: /(@copyright .*?) 2015(-\d{4})?/g,
                        replacement: '$1 ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()
                    }]
                }
            },
            version: {
                files: [{
                    src: 'core/components/imageplus/model/imageplus/imageplus.class.php',
                    dest: 'core/components/imageplus/model/imageplus/imageplus.class.php'
                }],
                options: {
                    replacements: [{
                        pattern: /version = '\d+.\d+.\d+[-a-z0-9]*'/ig,
                        replacement: 'version = \'' + '<%= modx.version %>' + '\''
                    }]
                }
            },
            inputoptions: {
                files: [{
                    src: 'core/components/imageplus/elements/tv/input/tpl/imageplus.options.tpl',
                    dest: 'core/components/imageplus/elements/tv/input/tpl/imageplus.options.tpl'
                }],
                options: {
                    replacements: [{
                        pattern: /&copy; 2015(-\d{4})?/g,
                        replacement: '&copy; ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()
                    }]
                }
            },
            outputoptions: {
                files: [{
                    src: 'core/components/imageplus/elements/tv/output/tpl/imageplus.options.tpl',
                    dest: 'core/components/imageplus/elements/tv/output/tpl/imageplus.options.tpl'
                }],
                options: {
                    replacements: [{
                        pattern: /&copy; 2015(-\d{4})?/g,
                        replacement: '&copy; ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()
                    }]
                }
            },
            docs: {
                files: [{
                    src: 'mkdocs.yml',
                    dest: 'mkdocs.yml'
                }],
                options: {
                    replacements: [{
                        pattern: /&copy; 2015(-\d{4})?/g,
                        replacement: '&copy; ' + (new Date().getFullYear() > 2015 ? '2015-' : '') + new Date().getFullYear()
                    }]
                }
            }
        }
    });

    //load the packages
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.renameTask('string-replace', 'bump');

    //register the task
    grunt.registerTask('default', ['bump', 'uglify', 'sass', 'postcss', 'cssmin', 'usebanner']);
};
