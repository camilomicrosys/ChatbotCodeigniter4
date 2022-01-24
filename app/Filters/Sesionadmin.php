<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Sesionadmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here   aca validamos si hay sesion activa, si no existe la sesion de roll admin mandalo alinicio
        if (!session('Perfil') == 'Administrador' || !session('Perfil') == 'Asesor' || !session('Perfil') == 'Cliente') {
            return redirect()->to(base_url() . route_to('principal'))->with('mensaje', '0');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
