document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#checkin", {
        dateFormat: "d-m-Y", // Formato de fecha (año-mes-día)
        minDate: "today",    // Fecha mínima: hoy
        locale: "es"         // Cambia el idioma a español
    });

    flatpickr("#checkout", {
        dateFormat: "d-m-Y",
        minDate: "today",
        locale: "es"
    });
});