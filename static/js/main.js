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


// CARRUSEL PRINCIPAL

let currentIndex = 0;
const backgrounds = document.querySelectorAll('.carousel-background'); // Selecciona todas las imágenes de fondo

// Función para cambiar el fondo
function changeBackground() {
    // Ocultar la imagen actual
    backgrounds[currentIndex].style.opacity = 0;
    
    // Avanzar al siguiente fondo, asegurándonos de que sea cíclico
    currentIndex = (currentIndex + 1) % backgrounds.length;
    
    // Mostrar la siguiente imagen
    backgrounds[currentIndex].style.opacity = 1;
}

// Iniciar el carrusel con un intervalo de 5 segundos
function startBackgroundCarousel() {
    setInterval(changeBackground, 3000); // Cambiar cada 5 segundos
}

// Iniciar el carrusel de fondo cuando la página cargue
window.onload = startBackgroundCarousel;

