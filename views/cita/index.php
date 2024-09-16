<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tu servicio a continuacion.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<div class="app">

    <nav class="tabs">
        <button class="tab-activo" type="button" data-paso="1">Servicios</button>
        <button class="" type="button" data-paso="2">Informacion</button>
        <button class="" type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="session">
        <h2>Servicio</h2>
        <p class="text-center">Elige tu servicio</p>
        <div id="servicios" class="listado-servicios">

        </div>

    </div>

    <div id="paso-2" class="session">
        <h2>Tu datos y cita</h2>
        <p class="text-center">Coloca los datos y fecha de la cita.</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?= $nombre . ' ' . $apellido ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?= date('Y-m-d') ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
        </form>

    </div>
    <div id="paso-3" class="session contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta.</p>
    </div>

    <div class="paginacion">
        <button type="button" class="button" id="anterior">&laquo; Anterior</button>
        <button type="button" class="button" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php $script = '<script src="build/js/app.js"></script>';?>