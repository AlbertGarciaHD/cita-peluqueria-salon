let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const citas = {
    nombre: "",
    fecha: "",
    hora: "",
    servicios: [],
    idServicios: []
};

document.addEventListener("DOMContentLoaded", () => {
    inicialApp();
});


function inicialApp() {
    mostrarSession();
    tabs();
    paginador();
    paginaSigueinte();
    paginaAnterior();
    consultarAPI();
    mostrarNombre();
    selecionarFecha();
    selecionarHora();
    mostrarResumen();
}

function tabs() {
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach( boton => {
        boton.addEventListener("click", (e) => {
            paso = parseInt(e.target.dataset.paso);
            mostrarSession();
            paginador();
        });
    });

}

function mostrarSession() {
    const sessionAnterior = document.querySelector(`.mostrar`);
    if(sessionAnterior){
        sessionAnterior.classList.remove("mostrar");
    }

    const session = document.querySelector(`#paso-${paso}`);
    session.classList.add("mostrar");

    const tabsnAnterior = document.querySelector(`.tab-activo`);
    if(tabsnAnterior){
        tabsnAnterior.classList.remove('tab-activo');
    }

    const tabs = document.querySelector(`[data-paso="${paso}"]`);
    tabs.classList.add("tab-activo");
}

function  paginador() {
    const pagSig = document.querySelector("#siguiente");
    const pagAnt = document.querySelector("#anterior");
    const btnReservar =  document.querySelector("#boton-reservar");

    if(btnReservar && paso != 3 ){
        btnReservar.remove();
    }

    if( paso === 1 ) {
        pagAnt.classList.add("ocultar-btn");
        pagSig.classList.remove("ocultar-btn");
    } else if(paso === 2) {
        pagAnt.classList.remove("ocultar-btn");
        pagSig.classList.remove("ocultar-btn");
    } else if(paso === 3) {
        pagAnt.classList.remove("ocultar-btn");
        pagSig.classList.add("ocultar-btn");
        mostrarResumen();
    }
}

function paginaAnterior(){
    const pagAnt = document.querySelector("#anterior");
    pagAnt.addEventListener("click", () => {
        if( paso <= pasoInicial ) return;
        paso--;
        mostrarSession();
        paginador();
    });
}

function paginaSigueinte(){
    const pagSig = document.querySelector("#siguiente");
    pagSig.addEventListener("click", () => {
        if( paso >= pasoFinal ) return;
        paso++;
        mostrarSession();
        paginador();
    });
}

async function consultarAPI() {

    try {
        const url = "http://localhost:8082/api/servicios";
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios( servicios );
        console.log(servicios);

    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(  servicios ) {
    const contenedorServicios = document.querySelector("#servicios");

    servicios.innerHTML = "";

    servicios.forEach( servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = () => seleccionarServicio( servicio );

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        contenedorServicios.appendChild(servicioDiv);

    });

}

function seleccionarServicio( servicio ) {
    const { servicios } = citas;
    const { id } = servicio;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    if( servicios.some( agregado => agregado.id === id ) ) {
        citas.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove("seleccionado");
    } else {
        citas.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
}

function mostrarNombre() {
    citas.nombre = document.querySelector("#nombre").value;

}

function selecionarFecha() {
    const fecha = document.querySelector("#fecha");
    fecha.addEventListener("input", (e) => {

        const dia = new Date(e.target.value).getUTCDay();
        if([6, 0].includes(dia)) {
            e.target.value = "";
            mostrarAlerta("No se puede agendar en fin de semana", 'error');
        } else {
            citas.fecha = e.target.value;
        }

    });
}

function selecionarHora() {
    const hora = document.querySelector("#hora");
    hora.addEventListener("input", (e) => {
        const citahora = e.target.value;
        const horaActual = citahora.split(':')[0];

        if( horaActual < 9 || horaActual > 18 ) {
            mostrarAlerta("La hora no es válida", 'error');
            e.target.value = "";
        } else {
            citas.hora = e.target.value;
        }

    });
}

function mostrarAlerta( mensaje, tipo = 'exito', contenedor = '#paso-2 p', desaparece = true ) {

    const alertaPrevia = document.querySelector(".alerta");
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    const alerta = document.createElement("D");
    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const formulario = document.querySelector(`${contenedor}`);
    formulario.appendChild(alerta);

    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen() {
    const resumen = document.querySelector(".contenido-resumen");

    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if( Object.values(citas).includes("") || citas.servicios.length === 0 ) {
        mostrarAlerta("Todos los campos son obligatorios", 'error', '#paso-3', false);
        return;
    }

    const { nombre, fecha, hora, servicios } = citas;
    const total = servicios.reduce((total, servicio) => total + servicio.precio, 0);

    const resumenServicios = document.createElement("H3");
    resumenServicios.classList.add("resumen-servicios");
    resumenServicios.innerHTML = `Resumen de Servicios`;
    resumen.appendChild(resumenServicios);

    servicios.forEach( servicio => {
        const contServicio = document.createElement("DIV");
        contServicio.classList.add("contenedor-servicio");

        const textoServicio = document.createElement("P");
        textoServicio.innerHTML = servicio.nombre;

        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio:</span> $${servicio.precio}`;

        contServicio.appendChild(textoServicio);
        contServicio.appendChild(precioServicio);

        resumen.appendChild(contServicio);
    });


    const citaServicios = document.createElement("H3");
    citaServicios.classList.add("cita-servicios");
    citaServicios.innerHTML = `Resumen de Cita`;
    resumen.appendChild(citaServicios);


    const resumenNombre = document.createElement("P");
    resumenNombre.innerHTML = `<span>Nombre: </span>${nombre}`;
    resumen.appendChild(resumenNombre);

    const resumenFecha = document.createElement("P");
    resumenFecha.innerHTML = `<span>Fecha: </span>${formatearFecha( fecha ) }`;
    resumen.appendChild(resumenFecha);

    const resumenHora = document.createElement("P");
    resumenHora.innerHTML = `<span>Hora: </span>${hora}`;
    resumen.appendChild(resumenHora);

    const botonReservar = document.createElement("BUTTON");
    botonReservar.classList.add("button");
    botonReservar.id = 'boton-reservar'
    botonReservar.textContent = "Reservar";
    botonReservar.onclick = reservarCita;
    // resumen.appendChild(botonReservar);
    const paginacion = document.querySelector(".paginacion");
    paginacion.appendChild(botonReservar);
}

function formatearFecha( fecha ) {
    const fechaNueva = new Date(fecha);
    const opciones = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    }
    return fechaNueva.toLocaleDateString("es-ES", opciones);
}

async function reservarCita() {
    const datos = new FormData();
    citas.idServicios = citas.servicios.map( servicio => servicio.id );
    
    datos.append("nombre", citas.nombre );
    datos.append("fecha", citas.fecha );
    datos.append("hora", citas.hora );
    datos.append("servicios", citas.idServicios );

    try {
    
        const url = "http://localhost:8082/api/citas";

        $resultado = await fetch(url, {
            method: "POST",
            body: datos
        });

        resultado = await $resultado.json();

        if( resultado.cod && resultado.cod === '00'){
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "Tu cita ha sido creada correctamente",
                button: "Ok"
            }).then(() => {
                window.location.reload();
            });

        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un error al crear la cita",
                button: "Ok"
            });
        }
        console.log(resultado);
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al crear la cita",
            button: "Ok"
        });
    }

}