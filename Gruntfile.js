module.exports = function (grunt) {

  'use strict';

  // load all grunt tasks
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    concat: {
      min: {
        files: {
          'public/js/app.js': [
            'public/js/src/bootstrap/affix.js',
            'public/js/src/bootstrap/alert.js',
            'public/js/src/bootstrap/button.js',
            'public/js/src/bootstrap/collapse.js',
            'public/js/src/bootstrap/dropdown.js',
            'public/js/src/bootstrap/tab.js',
            'public/js/src/bootstrap/transition.js',
            'public/js/src/bootstrap/scrollspy.js',
            'public/js/src/bootstrap/modal.js',
            'public/js/src/bootstrap/tooltip.js',
            'public/js/src/bootstrap/popover.js',
            'public/js/src/libs/*.js',
            'public/js/src/modules/*.js',
            'public/js/src/app.js',
          ]
        }
      }
    },

    uglify: {
      min: {
        files: {
          'public/js/app.js': [
            'public/js/src/bootstrap/affix.js',
            'public/js/src/bootstrap/alert.js',
            'public/js/src/bootstrap/button.js',
            'public/js/src/bootstrap/collapse.js',
            'public/js/src/bootstrap/dropdown.js',
            'public/js/src/bootstrap/tab.js',
            'public/js/src/bootstrap/transition.js',
            'public/js/src/bootstrap/scrollspy.js',
            'public/js/src/bootstrap/modal.js',
            'public/js/src/bootstrap/tooltip.js',
            'public/js/src/bootstrap/popover.js',
            'public/js/src/libs/*.js',
            'public/js/src/modules/*.js',
            'public/js/src/app.js',
          ]
        }
      }
    },

    compass: {
      dist: {
        options: {
          config: 'public/css/app.rb',
          sassDir: 'public/css/sass',
          imagesDir: 'public/img',
          cssDir: 'public/css',
          environment: 'production',
          outputStyle: 'compressed',
          force: true
        }
      }
    },

    browserSync: {
      files: {
        src: ['public/css/app.css'],
      },
      options: {
          host: "localhost",
          watchTask: true
      }
    },

    watch: {
      options: {
        livereload: true
      },
      scripts: {
        files: ['public/js/src/*.js','public/js/src/bootstrap/*.js','public/js/src/libs/*.js', 'public/js/src/modules/*.js'],
        tasks: ['uglify']
      },
      css: {
        files: ['public/css/**/*.{sass,scss}'],
        tasks: ['compass']
      }
    },
  });

  // Development task checks and concatenates JS, compiles SASS preserving comments and nesting, runs dev server, and starts watch
  grunt.registerTask('dev', ['compass', 'concat']);
  grunt.registerTask('default', ['compass', 'uglify', 'browserSync', 'watch']);

 }
