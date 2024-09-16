<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if( $error ) return; ?>

<form method="post" class="formulario">

    <div class="campo">
        <label for="email"> Password </label>
        <input 
            type="password" 
            name="password" 
            id="password"
            placeholder="Tu Nuevo Password"
        />
    </div>

    <div class="campo">
        <label for="email"> Repetir Password </label>
        <input 
            type="password" 
            name="password_confirm" 
            id="password-confirm"
            placeholder="Repetir Nuevo Password"
        />
    </div>

    <input type="submit" id="button" class="button" value="Guardar Password">
</form>

<div class="actions">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Aun no tiene una cuenta? Crear Una</a>
</div>