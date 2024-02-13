const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
//Enpaquetado del Login
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
    //Enpaquetado JS del registro
    mix.js('resources/js/registrarse.js', 'public/js/registrarse.js')
    mix.js('resources/js/actualizar.js', 'public/js/actualizar.js')
    //Enpaquetados JS varios
    mix.js('resources/js/firmar.js', 'public/js/firmar.js')
    mix.js('resources/js/archivo.js', 'public/js/archivo.js')
    mix.js('resources/js/nuevo_permiso.js', 'public/js/nuevo_permiso.js')
    mix.js('resources/js/delete.js', 'public/js/delete.js')
    mix.js('resources/js/enable.js', 'public/js/enable.js')

    //Enpaquetado para registros 
    mix.styles(['resources/css/registrarse2.css'], 'public/css/registrarse2.css');
    mix.styles(['resources/css/registrarse.css'], 'public/css/registrarse.css');
    mix.styles(['resources/css/prueba.css'], 'public/css/prueba.css');
    //Enpaquetado para vistas del empleado
    mix.styles(['resources/css/empleado/registros.css'], 'public/css/registros.css');
    mix.styles(['resources/css/empleado/empleado.css'], 'public/css/empleado.css');
    mix.styles(['resources/css/empleado/nuevo_permiso.css'], 'public/css/nuevo_permiso.css');
    //Enpaquetado para vistas del jefe
    mix.styles(['resources/css/jefe/jefe.css'], 'public/css/jefe.css');
    mix.styles(['resources/css/jefe/actualizar.css'], 'public/css/actualizar.css');
    mix.styles(['resources/css/jefe/solicitudes.css'], 'public/css/solicitudes.css');
    mix.styles(['resources/css/jefe/solicitud.css'], 'public/css/solicitud.css');
    //Enpaquetado para vistas de th
    mix.styles(['resources/css/th/revisar.css'], 'public/css/revisar.css');
    mix.styles(['resources/css/th/principal.css'], 'public/css/principal.css');
    mix.styles(['resources/css/th/firmar.css'], 'public/css/firmar.css');
    mix.styles(['resources/css/th/archivo.css'], 'public/css/archivo.css');
    //Enpaquetado para vistas del admin
    mix.styles(['resources/css/delete.css'], 'public/css/delete.css');
    mix.styles(['resources/css/enable.css'], 'public/css/enable.css');
    mix.styles(['resources/css/view.css'], 'public/css/view.css');