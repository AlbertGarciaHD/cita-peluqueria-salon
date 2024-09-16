<?php
    namespace Middleware;
    
    class AuthMiddleware {
        public static function handle() {
            // session_start();
            // print_r($_SESSION);
            if (!isset($_SESSION['login']) || $_SESSION['login'] != true ) {
                header('Location: /');
                exit;
            }
        }
    }
?>