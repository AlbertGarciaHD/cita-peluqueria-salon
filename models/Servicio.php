<?php
namespace Model;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'sexo', 'estado'];

    public $id;
    public $nombre;
    public $precio;
    public $sexo;
    public $estado;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }


}