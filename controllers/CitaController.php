<?php
namespace Controllers;

use Middleware\AuthMiddleware;
use MVC\Router;

class CitaController {
    public function __construct()
    {
    }

    public static function index(Router $router) 
    {
        isAuth();
        
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'apellido' => $_SESSION['apellido'],
        ]);
    }
}