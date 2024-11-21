// Selecciona el elemento main-up
const mainUp = document.querySelector('.main-up');

// Escucha el evento de desplazamiento
window.addEventListener('scroll', () => {
    // Detecta la posición de scroll
    if (window.scrollY > window.innerHeight) {
        // Si estamos más abajo que la imagen, aplica el fondo blanco
        mainUp.classList.add('scrolled');
        mainUp.classList.remove('transparent');
    } else {
        // Si estamos sobre la imagen, mantén el fondo transparente
        mainUp.classList.add('transparent');
        mainUp.classList.remove('scrolled');
    }
});


flatpickr("#start-date", {
    dateFormat: "Y-m-d", // Formato de la fecha
    minDate: "today" // La fecha mínima que se puede seleccionar es el día de hoy
});

flatpickr("#end-date", {
    dateFormat: "Y-m-d", // Formato de la fecha
    minDate: "today" // La fecha mínima que se puede seleccionar es el día de hoy
});