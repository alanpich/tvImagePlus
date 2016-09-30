module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        modx: grunt.file.readJSON('_build/config.json'),
        sshconfig: grunt.file.readJSON('/Users/jako/Documents/MODx/partout.json'),
        banner: '/*!\n' +
        ' * <%= modx.name %> - <%= modx.description %>\n' +
        ' * Version: <%= modx.version %>\n' +
        ' * Build date: <%= grunt.template.today("yyyy-mm-dd") %>\n' +
        ' */\n',
        usebanner: {
            css: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/imageplus/css/mgr/imageplus.min.css',
                        'assets/components/imageplus/css/mgr/imageplus-22.min.css'
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
            imageplus: {
                src: [
                    'source/js/mgr/imageplus.js',
                    'source/js/mgr/imageplus.panel.input.js',
                    'source/js/mgr/imageplus.window.editor.js',
                    'source/js/mgr/imageplus.migx_renderer.js',
                    'source/js/mgr/tools/JSON2.js',
                    'source/js/mgr/jquery/jquery.min.js',
                    'source/js/mgr/jquery/jquery.jcrop.min.js',
                    'source/js/mgr/imageplus.jquery.imagecrop.js'
                ],
                dest: 'assets/components/imageplus/js/mgr/imageplus.min.js'
            }
        },
        sass: {
            options: {
                outputStyle: 'expanded',
                sourcemap: false
            },
            dist: {
                files: {
                    'source/css/mgr/imageplus.css': 'source/sass/mgr/imageplus.scss'
                }
            }
        },
        cssmin: {
            imageplus: {
                src: [
                    'source/css/mgr/imageplus.css',
                    'source/css/mgr/jquery.jcrop.min.css'
                ],
                dest: 'assets/components/imageplus/css/mgr/imageplus.min.css'
            },
            imageplus22: {
                src: [
                    'source/css/mgr/imageplus-22.css',
                    'source/css/mgr/jquery.jcrop.min.css'
                ],
                dest: 'assets/components/imageplus/css/mgr/imageplus-22.min.css'
            }
        },
        sftp: {
            css: {
                files: {
                    "./": [
                        'assets/components/imageplus/css/mgr/imageplus.min.css',
                        'assets/components/imageplus/css/mgr/imageplus-22.min.css'
                    ]
                },
                options: {
                    path: '<%= sshconfig.hostpath %>develop/imageplus/',
                    srcBasePath: 'develop/imageplus/',
                    host: '<%= sshconfig.host %>',
                    username: '<%= sshconfig.username %>',
                    privateKey: '<%= sshconfig.privateKey %>',
                    passphrase: '<%= sshconfig.passphrase %>',
                    showProgress: true
                }
            },
            js: {
                files: {
                    "./": ['assets/components/imageplus/js/mgr/imageplus.min.js']
                },
                options: {
                    path: '<%= sshconfig.hostpath %>develop/imageplus/',
                    srcBasePath: 'develop/imageplus/',
                    host: '<%= sshconfig.host %>',
                    username: '<%= sshconfig.username %>',
                    privateKey: '<%= sshconfig.privateKey %>',
                    passphrase: '<%= sshconfig.passphrase %>',
                    showProgress: true
                }
            }
        },
        watch: {
            scripts: {
                files: [
                    'source/js/mgr/**/*.js'
                ],
                tasks: ['uglify', 'usebanner:js', 'sftp:js']
            },
            css: {
                files: [
                    'source/sass/mgr/**/*.scss'
                ],
                tasks: ['sass', 'cssmin', 'usebanner:css', 'sftp:css']
            }
        },
        bump: {
            copyright: {
                files: [
                    {
                        src: 'core/components/imageplus/elements/plugins/imageplus.plugin.php',
                        dest: 'core/components/imageplus/elements/plugins/imageplus.plugin.php'
                    },
                    {
                        src: 'core/components/imageplus/elements/snippets/imageplus.snippet.php',
                        dest: 'core/components/imageplus/elements/snippets/imageplus.snippet.php'
                    },
                    {
                        src: 'core/components/imageplus/elements/tv/input/imageplus.class.php',
                        dest: 'core/components/imageplus/elements/tv/input/imageplus.class.php'
                    },
                    {
                        src: 'core/components/imageplus/elements/tv/input/options/imageplus.php',
                        dest: 'core/components/imageplus/elements/tv/input/options/imageplus.php'
                    },
                    {
                        src: 'core/components/imageplus/elements/tv/output/imageplus.class.php',
                        dest: 'core/components/imageplus/elements/tv/output/imageplus.class.php'
                    },
                    {
                        src: 'core/components/imageplus/elements/tv/output/options/imageplus.php',
                        dest: 'core/components/imageplus/elements/tv/output/options/imageplus.php'
                    },
                    {
                        src: 'core/components/imageplus/model/cropengines/AbstractCropEngine.php',
                        dest: 'core/components/imageplus/model/cropengines/AbstractCropEngine.php'
                    },
                    {
                        src: 'core/components/imageplus/model/cropengines/PhpThumbOf.php',
                        dest: 'core/components/imageplus/model/cropengines/PhpThumbOf.php'
                    },
                    {
                        src: 'core/components/imageplus/model/cropengines/PhpThumbsUp.php',
                        dest: 'core/components/imageplus/model/cropengines/PhpThumbsUp.php'
                    },
                    {
                        src: 'core/components/imageplus/model/imageplus/imageplus.class.php',
                        dest: 'core/components/imageplus/model/imageplus/imageplus.class.php'
                    }
                ],
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
            }
        }
    });

    //load the packages
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-ssh');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.renameTask('string-replace', 'bump');

    //register the task
    grunt.registerTask('default', ['bump', 'uglify', 'sass', 'cssmin', 'usebanner', 'sftp']);
};