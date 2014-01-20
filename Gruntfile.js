/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

'use strict';

module.exports = function (grunt) {

  require('load-grunt-tasks')(grunt);

  grunt.initConfig({

    app: {
      vendors: 'bower_components',
      dist: 'web/assets'
    },

    clean: {
      dist: {
        src: '<%= app.dist %>/*'
      }
    },

    concat: {
      vendors_js: {
        src: [
          '<%= app.vendors %>/html5-boilerplate/js/plugins.js',
          '<%= app.vendors %>/html5-boilerplate/js/main.js',
          '<%= app.vendors %>/bootstrap/dist/js/bootstrap.min.js'
        ],
        dest: '<%= app.dist %>/js/vendor.js'
      },
      vendors_css: {
        src: [
          '<%= app.vendors %>/html5-boilerplate/css/normalize.css',
          '<%= app.vendors %>/html5-boilerplate/css/main.css',
          '<%= app.vendors %>/bootstrap/dist/css/bootstrap.min.css'
        ],
        dest: '<%= app.dist %>/css/vendor.css'
      }
    },

    copy: {
      vendors: {
        files: [
          {
            expand: true,
            cwd: '<%= app.vendors %>/',
            dest: '<%= app.dist %>/js/libs/',
            src: [
              'jquery/jquery.min.js',
              'jquery/jquery.min.map'
            ]
          }
        ]
      }
    }

  });

  grunt.registerTask('default', [
    'clean',
    'copy:vendors',
    'concat:vendors_js',
    'concat:vendors_css'
  ]);
}