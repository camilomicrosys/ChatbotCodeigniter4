<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LoginController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//esta es la vista del bot de citas cada bot tiene una unica vista ya que es asincrono
$routes->get('/', 'BotcitasController::botCitas', ['as' => 'botCitas']);
//boton 1 saludo
$routes->post('/saludo-citas', 'BotcitasController::saludoCitas', ['as' => 'saludoCitas']);
//boton 2 cedula para consultar las obligaciones 
$routes->post('/cedula-consultaws-si-tiene-citas', 'BotcitasController::cedulaConsultawsSiTieneCitas', ['as' => 'consultaDecitas']);
//menu principal agendamientos 
$routes->post('/menuppal-agendamiento', 'BotcitasController::menuppalAgendamiento', ['as' => 'menuppalAgendamientoAsesor']);
//aca hacemos el paso asesor
$routes->post('/menuppal-asesor', 'BotcitasController::menuppalAsesor', ['as' => 'menuppalAsesor']);
//aca se actualiza la bd con la citaque selecciono el cliente y se le asigna a la cedula agendada
$routes->post('/cita-agendada', 'BotcitasController::citaSeleecionada', ['as' => 'citaSeleecionada']);
//mostramos las citas disponibles para que el usuario elja una y la actualize
$routes->post('/mostrar-citas-actualizar', 'BotcitasController::mostrarCitaActualizar', ['as' => 'mostrarCitaActualizar']);
//aca hacemos la insercion final en la bd dejamos libre la cita que tenia y le asignamos la nueva
$routes->post('/actualizado-final-cita', 'BotcitasController::actualizadoCitaFinal', ['as' => 'actualizadoCitaFinal']);
//aca cancelamos la cita
$routes->post('/cancelar-cita', 'BotcitasController::cancelarCita', ['as' => 'cancelarCita']);
$routes->post('/consulta-mi-cita', 'BotcitasController::consultaMiCita', ['as' => 'consultaMiCita']);





//esta ruta tiene un formulario en el cual en el action envio los datos a la ruta post que nececite toco crearla auxiliar para poder identificar los errores
 $routes->get('/pruebas-formulario', 'BotcitasController::pruebasFormulario', ['as' => 'pruebasFormulario']);
 




//ruta auxiliar para yo probar  
$routes->get('/auxiliar', 'BotcitasController::probandoBot', ['as' => 'aux']);


//INICIO RUTAS DEL WS SERVICIO REST FULL
//pasamos ruta de tipo recurso pasamos el mismo nombre de la clase por que al parecer en ci esta presentando error si ponemos otro nombre ponemos array asocitaivo controller es igual al nombre del controlador
$routes->resource('WebServiceCitasController',['controller'=>'WebServiceCitasController']);








//---------------------------------------------------------------------------------------------------



//enviar email esta ruta no hace nada, ya que en el bot controller enviamos los email desde el modelo no hay que crear clases solo copiar lo que esta en email controller en la funcion es solo poner eso y ya codeigniter  envia solo
$routes->get('/enviar-email','EmailController::envioCorreo',['as'=>'envioCorreo']);

  





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
