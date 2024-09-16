<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/olvide" method="post" class="formulario">

    <div class="campo">
        <label for="email"> Email </label>
        <input 
            type="email" 
            name="email" 
            id="email"
            placeholder="You Email"
            value="<?= s($email) ?>"
        />
    </div>

    <input type="submit" id="button" class="button" value="Enviar Instruciones">
</form>

<div class="actions">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Aun no tiene una cuenta? Crear Una</a>
</div>