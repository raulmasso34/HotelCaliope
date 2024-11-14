document.addEventListener("DOMContentLoaded", function () {
    // Seleccionamos todos los contenedores de imágenes (carruseles)
    const carousels = document.querySelectorAll(".hoteles-img");

    carousels.forEach((carousel) => {
        const images = carousel.querySelectorAll("img");
        let currentIndex = 0;

        // Función para mostrar la imagen actual
        function showSlide(index) {
            // Remover la clase 'active' de todas las imágenes
            images.forEach((img) => img.classList.remove("active"));
            // Añadir la clase 'active' solo a la imagen que debe mostrarse
            images[index].classList.add("active");
        }

        // Función para ir a la siguiente imagen
        function nextSlide() {
            currentIndex = (currentIndex + 1) % images.length;  // Ciclamos entre las imágenes
            showSlide(currentIndex);
        }

        // Función para ir a la imagen anterior
        function prevSlide() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;  // Ciclamos entre las imágenes
            showSlide(currentIndex);
        }

        // Seleccionamos los botones de "next" y "prev" que están en el mismo contenedor que las imágenes
        const nextButton = carousel.parentNode.querySelector(".next");
        const prevButton = carousel.parentNode.querySelector(".prev");

        // Aseguramos que los botones existan antes de asignar los eventos
        if (nextButton && prevButton) {
            nextButton.addEventListener("click", nextSlide);  // Asignamos el evento "next"
            prevButton.addEventListener("click", prevSlide);  // Asignamos el evento "prev"
        }

        // Inicializamos el carrusel mostrando la primera imagen
        showSlide(currentIndex);
    });
});
