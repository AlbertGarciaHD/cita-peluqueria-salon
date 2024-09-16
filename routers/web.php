<?php

use Controllers\APIController;
use Controllers\CitaController;
use MVC\Router;
    use Controllers\LoginController;

    // Instancia del router
    $router = new Router();

    // Agrupación de rutas relacionadas con el login
    $router->get('/', [LoginController::class, 'login']);
    $router->post('/', [LoginController::class, 'login']);
    $router->get('/logout', [LoginController::class, 'logout']);

    // Rutas de recuperación de contraseña
    $router->get('/olvide', [LoginController::class, 'olvide']);
    $router->post('/olvide', [LoginController::class, 'olvide']);
    $router->get('/recuperar', [LoginController::class, 'recuperar']);
    $router->post('/recuperar', [LoginController::class, 'recuperar']);


    
    // Rutas de recuperación de contraseña
    $router->get('/crear-cuenta', [LoginController::class, 'crear']);
    $router->post('/crear-cuenta', [LoginController::class, 'crear']);

        
    // Confirmar Cuenta
    $router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
    $router->post('/confirmar-cuenta', [LoginController::class, 'confirmar']);
    $router->get('/mensaje', [LoginController::class, 'mensaje']);

    // Administrador de Usuarios
    $router->get('/dashboard', [LoginController::class, 'dashboard']);

    //Usuarios accesos a las webs
    $router->get('/cita', [CitaController::class, 'index']);


    //Api de citas
    $router->get('/api/servicios', [APIController::class, 'index']);
    // $router->post('/api/citas', [APIController::class, 'guardar']);

    // Comprueba y valida las rutas definidas
    $router->comprobarRutas();