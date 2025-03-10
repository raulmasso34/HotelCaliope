document.addEventListener('DOMContentLoaded', function() {
    const serviciosSeleccionados = []; // Array para guardar los servicios seleccionados

    // Función para actualizar el texto del botón de continuar dependiendo de la selección
    function actualizarBotonContinuar() {
        const btnContinuar = document.getElementById('btn-continuar');
        const serviciosSeleccionadosInput = document.getElementById('servicios_seleccionados');

        // Si hay servicios seleccionados, cambia el texto del botón a "Continuar"
        if (serviciosSeleccionados.length > 0) {
            btnContinuar.value = "Continuar";
        } else {
            // Si no hay servicios seleccionados, muestra "Continuar sin servicio"
            btnContinuar.value = "Continuar sin servicio";
        }

        // Actualizamos el input oculto con los servicios seleccionados
        serviciosSeleccionadosInput.value = JSON.stringify(serviciosSeleccionados);
    }

    // Evento para el botón "Seleccionar" de cada servicio
    const botonesReservar = document.querySelectorAll('.btn-reservar');
    botonesReservar.forEach(function(boton) {
        boton.addEventListener('click', function() {
            const servicioId = this.getAttribute('data-id');
            const servicioElemento = document.getElementById('servicio-' + servicioId);

            // Si el servicio ya está seleccionado, lo deseleccionamos
            if (servicioElemento.classList.contains('seleccionado')) {
                servicioElemento.classList.remove('seleccionado');
                // Remover de la lista de servicios seleccionados
                const index = serviciosSeleccionados.findIndex(servicio => servicio.id === servicioId);
                if (index > -1) {
                    serviciosSeleccionados.splice(index, 1);
                }
            } else {
                servicioElemento.classList.add('seleccionado');
                // Agregar el servicio a la lista de seleccionados
                serviciosSeleccionados.push({ id: servicioId, precio: this.getAttribute('data-precio') });
            }

            // Actualizamos el texto del botón y el input con los servicios seleccionados
            actualizarBotonContinuar();
        });
    });

    // Evento para el botón "Continuar" (en el formulario)
    const formularioContinuar = document.querySelector('form');
    formularioContinuar.addEventListener('submit', function() {
        // Se enviarán los IDs de los servicios seleccionados al formulario
        document.getElementById('servicios_seleccionados').value = JSON.stringify(serviciosSeleccionados);
    });

    // Llamada inicial para actualizar el botón de continuar al cargar la página
    actualizarBotonContinuar();
});
