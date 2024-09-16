<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Iniciar sesion con tus datos.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/" method="post" class="formulario">
    <div class="campo">
        <label for="email"> Email </label>
        <input 
            type="email" 
            name="email" 
            id="email"
            placeholder="You Email"
            value="<?= s($usuario->email) ?>"
        />
    </div>

    <div class="campo">
        <label for="password"> Password </label>
        <input 
            type="password" 
            name="password" 
            id="password"
            placeholder="You Password"
        />
    </div>

    <input type="submit" value="Iniciar Session" id="button" class="button">
</form>

<div class="actions">
    <a href="/crear-cuenta">Aun no tiene una cuenta? Crear Una</a>
    <a href="/olvide">Olvidaste tu Password?</a>
</div>