<?php 

// Implementa en tu Router o Controlador
if (!isset($_SESSION)) {
    session_start();
}

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

require_once __DIR__ . '/../routers/web.php';  // Carga las rutas definidas