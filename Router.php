<?php

namespace MVC;

use Exception;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    // Método genérico para registrar rutas
    public function addRoute($method, $url, $fn)
    {
        $this->routes[$method][$url] = $fn;
    }

    public function get($url, $fn)
    {
        $this->addRoute('GET', $url, $fn);
    }

    public function post($url, $fn)
    {
        $this->addRoute('POST', $url, $fn);
    }

    public function comprobarRutas()
    {
        // Arreglo de rutas protegidas...
        // $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        // $auth = $_SESSION['login'] ?? null;

        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $fn = $this->routes[$method][$currentUrl] ?? null;

        if ($fn) {
            try {
                // Llama a la función asociada a la ruta
                echo call_user_func($fn, $this);
            } catch (Exception $e) {
                $this->handleError($e->getMessage());
            }
        } else {
            $this->handleError("Página No Encontrada o Ruta no válida", 404);
        }
    }

    private function handleError($message, $code = 500)
    {
        http_response_code($code);
        echo $message;
    }

    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        extract($datos);

        ob_start(); 
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer

        include_once __DIR__ . '/views/layout.php';
    }
}
