document.addEventListener('DOMContentLoaded', function () {
    // Obtener referencias a los elementos
    const checkboxesServicios = document.querySelectorAll('input[name="servicios[]"]');
    const checkboxesActividades = document.querySelectorAll('input[name="actividades[]"]');
    const btnContinuar = document.getElementById('btn-continuar');

    function actualizarBotonContinuar() {
        // Verificar si hay servicios o actividades seleccionadas
        const serviciosSeleccionados = Array.from(checkboxesServicios).some(cb => cb.checked);
        const actividadesSeleccionadas = Array.from(checkboxesActividades).some(cb => cb.checked);

        // Cambiar el texto del botón según la selección
        btnContinuar.value = (serviciosSeleccionados || actividadesSeleccionadas) 
            ? "Continuar"
            : "Continuar sin selección";
    }

    // Agregar eventos a los checkboxes para actualizar el botón
    checkboxesServicios.forEach(cb => cb.addEventListener('change', actualizarBotonContinuar));
    checkboxesActividades.forEach(cb => cb.addEventListener('change', actualizarBotonContinuar));

    // Llamada inicial para actualizar el botón al cargar la página
    actualizarBotonContinuar();
});
