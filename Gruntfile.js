module.exports = function(grunt) {

  grunt.registerTask('watch', [ 'watch' ]);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // concat
    concat: {
         js: {
           options: {
             separator: ';'
           },
           src: ['js/src/**/*.js'],
           dest: 'js/<%= pkg.name %>.min.js'
         },
       },

    // uglify
    uglify: {
        options: {
          mangle: false
        },
        js: {
          files: {
            'js/<%= pkg.name %>.min.js': ['js/<%= pkg.name %>.min.js']
          }
        }
      },

    // LESS CSS
    less: {
      style: {
        options: {
          compress: true
        },
        files: {
          "style.css": "less/style.less"
        }
      }
    },

    svgstore: {
      options: {
        prefix : 'icon-', // This will prefix each <g> ID
         svg : {
            'xmlns:sketch' : 'http://www.bohemiancoding.com/sketch/ns',
            'xmlns:dc': "http://purl.org/dc/elements/1.1/",
            'xmlns:cc': "http://creativecommons.org/ns#",
            'xmlns:rdf': "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
            'xmlns:svg': "http://www.w3.org/2000/svg",
            'xmlns': "http://www.w3.org/2000/svg",
            'xmlns:sodipodi': "http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd",
            'xmlns:inkscape': "http://www.inkscape.org/namespaces/inkscape"
        }
      },
      default : {
        files: {
            // svgs in the combined folder will be combined into the svg-defs.svg file
            // usage: <svg><use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-name-of-svg'; ?>"></use></svg>
            'images/svg-defs.svg': ['images/svgs/combined/*.svg'],
        }
      }
    },

    // Add banner to style.css
    usebanner: {
       addbanner: {
          options: {
            position: 'top',
            banner: '/*\nTheme Name: Restrict Content Pro\n' +
                    'Template: <%= pkg.parentTheme %>\n' +
                    'Theme URI: <%= pkg.theme_uri %>\n' +
                    'Author: Andrew Munro\n' +
                    'Author URI: http://sumobi.com\n' +
                    'Description: The theme for Restrict Content Pro\n' +
                    'License: GNU General Public License\n' +
                    'License URI: license.txt\n' +
                    '*/',
            linebreak: true
          },
          files: {
            src: [ 'style.css' ]
          }
        }
    },

    svgmin: { //minimize SVG files
        options: {
            plugins: [
                { removeViewBox: false },
                { removeUselessStrokeAndFill: false }
            ]
        },
        dist: {
            expand: true,
            cwd: 'images/svgs/original',
            src: ['*.svg'],
            dest: 'images/svgs'
        }
    },

    // watch our project for changes
    watch: {
      // JS
      js: {
        files: ['js/src/**/*.js'],
        tasks: ['concat:js', 'uglify:js'],
      },

      // svgstore
       svgstore: {
         files: ['images/svgs/combined/*.svg'],
         tasks: ['svgstore:default']
      },

      // svgmin
      svgmin: {
          files: ['images/svgs/original/*.svg'],
          tasks: ['svgmin:dist']
      },

      // CSS
      css: {
        // compile CSS when any .less file is compiled in this theme and also the parent theme
        files: ['less/**/*.less', '../<%= pkg.parentTheme %>/assets/less/**/*.less'],
        tasks: ['less:style'],
      },
      // Add banner
      addbanner: {
        files: 'style.css',
         tasks: ['usebanner:addbanner'],
         options: {
          spawn: false
        }
      },

    }
  });

  // Saves having to declare each dependency
  require( "matchdep" ).filterDev( "grunt-*" ).forEach( grunt.loadNpmTasks );

  grunt.registerTask('default', ['concat', 'uglify', 'less', 'svgstore', 'svgmin', 'usebanner' ]);
};
