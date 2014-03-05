module.exports = function (grunt) {
  'use strict';

  grunt.initConfig({
    watch: {
      src: {
        files: ['index.php', '../app/**/*.*', '!../app/storage/**/*.*'],
        options: {
          livereload: true
        }
      },
      less: {
        files: ['less/**/*.less', 'vendor/bower_components/bootstrap/less/*.less', 'less/*.less'],
        tasks: ['less'],
        options: {
          livereload: true
        }
      }
    },

    less: {
      src: {
        files: {
          // target.css file: source.less file
          "styles/css/custom.css": "less/custom.less",
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
};
