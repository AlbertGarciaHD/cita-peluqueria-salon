<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {  
        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->sincronizar($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    // Verificar el password
                    if( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        // Autenticar el usuario
                        $authenticado = $usuario->autenticar();
                        // debuguear($usuario);

                        if($authenticado  && $usuario->administrador === '1' ) {
                            debuguear($usuario);
                            header('Location: /dashboard');
                        } else  if($authenticado  && $usuario->administrador === '0' ) {
                            header('Location: /cita');
                        }
                    } 

                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe');
                }
            }
            $alertas = Usuario::getAlertas();
        }

        $router->render('auth/login', [
            'alertas' => $alertas,
            'usuario' => $auth
        ]);
    }

    public static function logout() {
        echo "Desde logout";
    }

    public static function olvide(Router $router) {  
        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if( empty($alertas) ) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $auth->email);

                if( $usuario && $usuario->confirmado === "1" ) {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    $usuario->guardar();
                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Revisa tu email');
                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }

            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
            'email' => $auth->email ?? ''
        ]);
    }

    public static function recuperar( Router $router ) {

        $alertas = [];
        $error = false;
        $token = s( $_GET['token'] );
        if( !$token ) {
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        } else {
            $usuario = Usuario::where('token', $token);

            if( !$usuario ) {
                Usuario::setAlerta('error', 'Token No Válido');
                $error = true;
            } 
        }

        if( $_SERVER['REQUEST_METHOD'] === 'POST' && !$error ) {
            // Hashear el nuevo password
            $password = new Usuario($_POST);
            $password->password_confirm = $_POST['password_confirm'];
            $alertas = $password->validarPasswordConfirm();

            if( empty($alertas) ) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if( $resultado ) {
                    $_SESSION['password-recuperar'] = [ 'exito' => 'Password Actualizado Correctamente' ];
                    header('Location: /');
                }
            }    
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function confirmar(Router $router) {

        $alertas = [];
        $token = s($_GET['token']);
        if( !$token ) {
            header('Location: /crear-cuenta');
        }

        $usuario = Usuario::where('token', $token);

        if( empty($usuario) ) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router) {  

        $usuario = new Usuario;
        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();

            if( empty($alertas) ) {
                // Verificar que el usuario no exista
                $resultado = $usuario->existeUsuario();
                
                if( $resultado->num_rows ){
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $resultado = $usuario->crearUsuario();

                    if( $resultado['resultado'] ) {     
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarConfirmacion();
                        header('Location: /mensaje');
                    }
                }
            }

        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function dashboard(Router $router) {
        $router->render('auth/dashboard/index');
    }

}