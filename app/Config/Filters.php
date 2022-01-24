<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'        => CSRF::class,
        'toolbar'     => DebugToolbar::class,
        'honeypot'    => Honeypot::class,
        //aca insertamos el filtro que creamos en la carpeta filtro para que se valide que si exista sesion coloco el nombre de la clase que puse en carpeta filters y bajamos abajo de este documento y aplicamos el filtro
        'Sesionadmin' => \App\Filters\Sesionadmin::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
        ],
        'after'  => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'Sesionadmin' => [
            //en filers carpeta bimos el before que asi esta estructurado el filtro y las url que aplicare esos filtros  y las separo por comas aca coloco las rutas que protegere y deben tener una sesion si no se cumple hace lo que diga  en carpeta filters esta clase Sesionadmin  ojo todas las rutas van dentro del array de sesionadmin si lo hago afuera no lo coge
            'before' => ['/inicio-sesion'],
            //en la clase se esta validando que sea dministrador y aca colocamos las rutas que queremos validar que la persona que entre sea administrador
            'before' => ['/inicio-crud'],
            // esta no funciona consultar en internet como proteger cuando la url pasa parametros de igual manera si elimino o actualizo no deja ahi si lo devuelve entonces no habria lio
            'before' => ['/obtener-datos/editar/(:any)'],
            'before' => ['/actualizar-crud'],

        ],

    ];
}
