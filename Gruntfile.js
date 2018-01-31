/* jshint node:true */
module.exports = function( grunt ){
	'use strict';

	grunt.initConfig({

		// Setting folder templates.
		dirs: {
			js: 'js',
			css: 'css'
		},

		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= dirs.js %>/*.js',
				'!<%= dirs.js %>/*.min.js',
				'!<%= dirs.js %>/html5shiv.js',
				'!<%= dirs.js %>/html5shiv.min.js',
				'!<%= dirs.js %>/jquery.sticky.js',
				'!<%= dirs.js %>/jquery.sticky.min.js',
				'!<%= dirs.js %>/jquery.bxslider.js',
				'!<%= dirs.js %>/jquery.bxslider.min.js',
				'!<%= dirs.js %>/jquery.parallax-1.1.3.js',
				'!<%= dirs.js %>/jquery.parallax-1.1.3.min.js'
			]
		},

		// Minify .js files.
		uglify: {
			options: {
				preserveComments: 'some'
			},
			dist: {
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>/',
					src: [
						'*.js',
						'!color-picker.js',
						'!customizer.js',
						'!image-uploader.js',
						'!metabox-toggle.js',
						'!.min.js'
					],
					dest: '<%= dirs.js %>/',
					ext: '.min.js'
				}]
			}
		},

		// Watch changes for assets.
		watch: {
			js: {
				files: [
					'<%= dirs.js %>/*.js',
					'!<%= dirs.js %>/*.min.js'
				],
				tasks: ['jshint', 'uglify']
			}
		},

		// Generate POT files.
		makepot: {
			dist: {
				options: {
					type: 'wp-theme',
					domainPath: 'languages',
					potFilename: 'foodhunt.pot',
					potHeaders: {
						'report-msgid-bugs-to': 'themegrill@gmail.com',
						'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
					}
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options: {
				text_domain: 'foodhunt',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src: [
					'**/*.php',
					'!node_modules/**'
				],
				expand: true
			}
		},

		// Compress files and folders.
		compress: {
			options: {
				archive: 'foodhunt.zip'
			},
			files: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!*.zip',
					'!.*/**',
					'!Gruntfile.js',
					'!package.json',
					'!node_modules/**'
				],
				dest: 'foodhunt',
				expand: true
			}
		},

		// Copy
		copy: {
			facss: {
				files: [{
					cwd: 'bower_components/font-awesome/css',  // set working folder / root to copy
					src: '**/*.css',           // copy all files and subfolders
					dest: 'fontawesome/css/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			fafonts: {
				files: [{
					cwd: 'bower_components/font-awesome/fonts',  // set working folder / root to copy
					src: '**/*',           // copy all files and subfolders
					dest: 'fontawesome/fonts/',    // destination folder
					expand: true           // required when using cwd
				}]
			},
			bxsliderjs: {
				files: [{
					cwd: 'bower_components/bxslider-4/dist/',  // set working folder / root to copy
					src: ['**/*.js', '!vendor/*.js'],           // copy all files and subfolders
					dest: 'js/',    // destination folder
					expand: true           // required when using cwd
				}]
			}
		},
		bower: {
			update: {
				//just run 'grunt bower:install' and you'll see files from your Bower packages in lib directory
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-bower-task' );

	// Register tasks
	grunt.registerTask( 'default', [
		'jshint',
		'uglify'
	]);

	grunt.registerTask( 'update', [
		'bower',
		'copy',
	]);

	grunt.registerTask( 'dev', [
		'default',
		'makepot'
	]);

	grunt.registerTask( 'zip', [
		'dev',
		'compress'
	]);
};
