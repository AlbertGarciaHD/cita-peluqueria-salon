<?php 
    if( isset($alertas) && !empty($alertas) ) :
        foreach($alertas as $key => $alerta) : 
            foreach($alerta as $mensaje) : ?>
            <div class="alerta <?= $key ?>">
                <?= $mensaje ?>
                <!-- <span class="cerrar-alerta" onclick="cerrarAlerta(this)">X</span> -->
            </div>

<?php       endforeach;  
        endforeach; 
    endif;
?>

<?php 
    if( isset( $_SESSION['password-recuperar'] ) ):
        $alertas = $_SESSION['password-recuperar'];
      
        unset($_SESSION['password-recuperar']);

        foreach($alertas as $key => $mensaje) : 
            echo "
            <div class=\"alerta $key\">
                $mensaje
            </div>";
        endforeach;

    endif;

?>