<?php 
namespace Controllers;

use Classes\Validador;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $response = [];

        if( $method == 'POST' ){
            $response = [];
            $_POST['usuarioId'] = $_SESSION['id'] ?? $_POST['usuarioId']; //usuarioId se usa para postman
    
            if( !$_POST['usuarioId'] ){
    
                return json_encode( [
                    'cod' => '01',
                    'errors' => [ 'login' => 'Error de Login' ] 
                ] ) ;
            } 
    

            $validador= new Validador($_POST);

            $rules = [
                'fecha' => 'required', 
                'hora' => 'required',
                'usuarioId' => 'required',
                'servicios' => 'required'
            ];

            if( $validador->validate( $rules) ){
                $cita = new Cita( $validador->getData() );
                $resul = $cita->guardar();

                if( $resul['resultado'] ){

                    $all_servicios = explode(',', $validador->getData()['servicios']);
                    foreach( $all_servicios as $servicio ){
                        $args = [
                            'citaId' => $resul['id'],
                            'servicioId' => $servicio
                        ];
                        $citaServicio = new CitaServicio( $args );
                        $citaServicio->guardar();
                    }

                    $response = [
                        'cod' => '00',
                        'success' => $resul,
                        'data' =>  $validador->getData()
                    ];
                } else {
                    $response = [
                        'cod' => '01',
                        'error' => 'Cita no creada.',
                        'data' =>  []
                    ];

                }
                $response = [ 
                    'cod' => ( $resul['resultado'] ) ? '00' : '01', 
                    'success' => $resul,
                    'data' =>  $validador->getData()
                ];
            } else {
                $response = ['cod'  => '01', 'errors' => $validador->errors()];
            }   
        } else {
            $response = [
                'cod' => '01',
                'errors' => [ 'metodo_error' => 'El metodo a enviar los datos no son Tipo POST' ]
            ];
        }

        return json_encode($response); 
    }

}