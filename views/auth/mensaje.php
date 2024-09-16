<h1 class="nombre-pagina">Confirma tu cuenta</h1>
<p class="descripcion-pagina">Hemos enviado las instruciones para confirmar tu cuenta por email.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- <form action="/crear-cuenta" method="post" class="formulario">
    <div class="campo">
        <label for="nombre"> Nombre </label>
        <input 
            type="text" 
            name="nombre" 
            id="nombre"
            placeholder="You First Name"
            value="<?= s($usuario->nombre) ?>"
        />
    </div>

    <div class="campo">
        <label for="apellido"> Apellido </label>
        <input 
            type="text" 
            name="apellido" 
            id="apellido"
            placeholder="You Last Name"
            value="<?= s($usuario->apellido) ?>"
        />
    </div>

    <div class="campo">
        <label for="telefono"> Telefono </label>
        <input 
            type="tel" 
            name="telefono" 
            id="telefono"
            placeholder="You Phone Number"
            value="<?= s($usuario->telefono) ?>"
        />
    </div>

    <div class="campo">
        <label for="sexo"> Sexo </label>
        <select name="sexo" id="sexo">
            <option value="" >-- Selecionar --</option>
            <option value="M" <?= s( $usuario->sexo ) == 'M' ? 'selected' : null ?>>Hombre</option>
            <option value="F" <?= s( $usuario->sexo ) == 'F' ? 'selected' : null ?>>Mujer</option>
        </select>
    </div>

    <div class="campo">
        <label for="email"> Email </label>
        <input 
            type="email" 
            name="email" 
            id="email"
            placeholder="You Email"
            value="<?= s( $usuario->email ) ?>"
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

    <input type="submit" id="button" class="button" value="Crear Cuenta">
</form> -->

<div class="actions">
    <a href="/">Iniciar Sesion</a>
    <a href="/olvide">Olvidaste tu Password?</a>
</div>