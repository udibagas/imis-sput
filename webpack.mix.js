let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .styles([
       'resources/assets/theme/css/entypo.css',
       'resources/assets/theme/css/font-awesome.min.css',
       'resources/assets/theme/css/plugins/css3-animate-it-plugin/animations.css',
       'resources/assets/theme/css/bootstrap.min.css',
       'resources/assets/theme/css/mouldifi-core.css',
       'resources/assets/theme/css/plugins/datepicker/bootstrap-datepicker.css',
       'resources/assets/theme/css/plugins/select2/select2.css',
       'resources/assets/theme/css/plugins/colorpicker/bootstrap-colorpicker.css',
       'resources/assets/jquery.bootgrid/jquery.bootgrid.css',
       'resources/assets/datetimepicker/bootstrap-datetimepicker.css',
       'resources/assets/toastr/toastr.min.css',
       'resources/assets/theme/css/mouldifi-forms.css'
   ], 'public/css/theme.css')
   .scripts([
       'resources/assets/theme/js/jquery.min.js',
       'resources/assets/theme/js/plugins/css3-animate-it-plugin/css3-animate-it.js',
       'resources/assets/theme/js/bootstrap.min.js',
       'resources/assets/theme/js/plugins/metismenu/jquery.metisMenu.js',
       'resources/assets/theme/js/plugins/blockui-master/jquery-ui.js',
       'resources/assets/theme/js/plugins/blockui-master/jquery.blockUI.js',
       'resources/assets/theme/js/plugins/jasny/jasny.bootstrap.min.js',
       'resources/assets/theme/js/plugins/select2/select2.full.min.js',
       'resources/assets/theme/js/plugins/datepicker/bootstrap-datepicker.js',
       'resources/assets/theme/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
       'resources/assets/jquery.bootgrid/jquery.bootgrid.js',
       'resources/assets/datetimepicker/moment.js',
       'resources/assets/datetimepicker/bootstrap-datetimepicker.min.js',
       'resources/assets/toastr/toastr.min.js',
       'resources/assets/js/bootbox.min.js',
       // 'resources/assets/js/echarts.min.js',
       'resources/assets/js/marquee.js',
       'resources/assets/js/my.js'
   ], 'public/js/theme.js')
   .scripts(['resources/assets/theme/js/functions.js'], 'public/js/functions.js')
   // .sass('resources/assets/sass/app.scss', 'public/css');
