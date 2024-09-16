<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord {
    
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'sexo', 'email', 'telefono', 'password', 'confirmado', 'token', 'administrador', 'created_at', 'updated_at'];

    public $id;
    public $nombre;
    public $apellido;
    public $sexo;
    public $email;
    public $telefono;
    public $password;
    public $confirmado;
    public $token;
    public $administrador;
    public $created_at;
    public $updated_at;
    public $password_confirm;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        $this->administrador = $args['administrador'] ?? '0';
        $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
        $this->updated_at = $args['updated_at'] ?? date('Y-m-d H:i:s');
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if(!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }

        if(!$this->sexo) {
            self::$alertas['error'][] = 'El Sexo es obligatorio';
        } elseif(!preg_match('/[a-zA-Z]/', $this->sexo) || !in_array($this->sexo, ['M', 'F'])) {
            self::$alertas['error'][] = 'El sexo no es valido';
        } 

        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        } elseif(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
        return self::$alertas;
    }

    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }
        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function crearUsuario() {
        $this->hashPassword();
        $this->crearToken();
        $this->sexo = strtolower($this->sexo);
        return $this->guardar();
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
            return false;
        } else {
            return true;
        }
    }

    public function autenticar() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
            echo "La sesión  está activa»";
        }

        $_SESSION['id'] = $this->id;
        $_SESSION['nombre'] = $this->nombre;
        $_SESSION['apellido'] = $this->apellido;
        $_SESSION['email'] = $this->email;
        $_SESSION['login'] = true;
        $_SESSION['administrador'] = null;
        $_SESSION['sexo'] = $this->sexo;

        if($this->administrador === '1') {
            $_SESSION['administrador'] = true;
        }

        return true;
    }

    public function validarPasswordConfirm() {
        
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        } else if(!$this->password_confirm) {
            self::$alertas['error'][] = 'El password Confirm es obligatorio';
        }elseif(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        } elseif($this->password !== $this->password_confirm) {
            self::$alertas['error'][] = 'Los password no son iguales';
        }
        return self::$alertas;
    }
}