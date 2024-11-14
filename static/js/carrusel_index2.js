// CARROUSEL PARA LA PARTE DE DESCRIPCION DE LAS CIUDADES

let currentIndex = 0;
const images = document.querySelectorAll(".hoteles-img img");

function showSlide(index) {
    // Oculta todas las imágenes, luego muestra solo la imagen actual
    images.forEach(img => img.classList.remove("active"));
    images[index].classList.add("active");
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % images.length;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showSlide(currentIndex);
}

// Inicializa el carrusel mostrando la primera imagen
showSlide(currentIndex);
