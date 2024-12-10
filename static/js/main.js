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
    setInterval(changeBackground, 3500); // Cambiar cada 5 segundos
}

// Iniciar el carrusel de fondo cuando la página cargue
window.onload = startBackgroundCarousel;


// SCROLL EFECTO
document.addEventListener('DOMContentLoaded', () => {
    const mainSection = document.querySelector('.main-main');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                mainSection.classList.add('visible');
                observer.unobserve(mainSection); // Deja de observar después de activar la animación
            }
        });
    }, {
        threshold: 0.4  // Se activa cuando el 30% del elemento es visible
    });

    observer.observe(mainSection);
});


document.addEventListener('DOMContentLoaded', () => {
    const opinions = document.querySelectorAll('.opinion'); // Todas las opiniones
    const dots = document.querySelectorAll('.dot');        // Todos los puntos

    let opinionIndex = 0; // Índice actual de la opinión

    // Función para mostrar la opinión activa
    function showOpinion(index) {
        opinions.forEach((opinion, i) => {
            opinion.classList.remove('active'); // Remover la clase activa de todas las opiniones
            dots[i].classList.remove('active'); // Remover la clase activa de todos los puntos
            if (i === index) {
                opinion.classList.add('active'); // Añadir la clase activa a la opinión actual
                dots[i].classList.add('active'); // Añadir la clase activa al punto actual
            }
        });
    }

    // Evento para cada punto
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            opinionIndex = i; // Actualizar el índice al que corresponde el punto
            showOpinion(opinionIndex);
        });
    });

    // Inicializa la primera opinión como activa
    showOpinion(opinionIndex);
});


var map = L.map('map').setView([41.545, 1.8], 2.499);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([41.545, 1.893]).addTo(map);
var marker = L.marker([40.70, -73.9]).addTo(map);
var marker = L.marker([42.879, -8]).addTo(map);
var marker = L.marker([26, -80.2]).addTo(map);
var marker = L.marker([34, -118.2]).addTo(map);
var marker = L.marker([41.7214, 2.936]).addTo(map);