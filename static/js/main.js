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




//-------------------------------IDIOMA---------------------------
function changeLanguage() {
    const lang = document.getElementById('language-select').value;
    
    // Cambiar el contenido de la página según el idioma seleccionado
    if (lang === 'es') {
        document.getElementById('about-hotel').innerText = 'Sobre el hotel';
        document.getElementById('about-hotel-text').innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam incidunt iste dolorum expedita eligendi omnis quia facere quod autem! Voluptatem.';
        document.getElementById('links-title').innerText = 'Links';
        document.getElementById('about-link').innerText = 'Sobre nosotros';
        document.getElementById('services-link').innerText = 'Servicios';
        document.getElementById('hotels-link').innerText = 'Hoteles';
        document.getElementById('location-title').innerText = 'Dónde nos encontramos';
        document.getElementById('address').innerHTML = 'Calle xxx 99999 <br> Lorem ipsum, España';
        document.getElementById('phone').innerText = '999 999 999';
        document.getElementById('email').innerText = 'hotelcalope@gmail.com';
    }
    else if (lang === 'en') {
        document.getElementById('about-hotel').innerText = 'About the hotel';
        document.getElementById('about-hotel-text').innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam incidunt iste dolorum expedita eligendi omnis quia facere quod autem! Voluptatem.';
        document.getElementById('links-title').innerText = 'Links';
        document.getElementById('about-link').innerText = 'About Us';
        document.getElementById('services-link').innerText = 'Services';
        document.getElementById('hotels-link').innerText = 'Hotels';
        document.getElementById('location-title').innerText = 'Where to find us';
        document.getElementById('address').innerHTML = 'Street xxx 99999 <br> Lorem ipsum, Spain';
        document.getElementById('phone').innerText = '999 999 999';
        document.getElementById('email').innerText = 'hotelcalope@gmail.com';
    }
    else if (lang === 'fr') {
        document.getElementById('about-hotel').innerText = 'À propos de l\'hôtel';
        document.getElementById('about-hotel-text').innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam incidunt iste dolorum expedita eligendi omnis quia facere quod autem! Voluptatem.';
        document.getElementById('links-title').innerText = 'Liens';
        document.getElementById('about-link').innerText = 'À propos de nous';
        document.getElementById('services-link').innerText = 'Services';
        document.getElementById('hotels-link').innerText = 'Hôtels';
        document.getElementById('location-title').innerText = 'Où nous trouver';
        document.getElementById('address').innerHTML = 'Rue xxx 99999 <br> Lorem ipsum, Espagne';
        document.getElementById('phone').innerText = '999 999 999';
        document.getElementById('email').innerText = 'hotelcalope@gmail.com';
    }
}

