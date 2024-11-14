document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll(".hoteles-img");

    carousels.forEach((carousel) => {
        const images = carousel.querySelectorAll("img");
        let currentIndex = 0;

        // Función para mostrar la imagen actual
        function showSlide(index) {
            images.forEach((img) => img.classList.remove("active"));
            images[index].classList.add("active");
        }

        // Función para ir a la siguiente imagen
        function nextSlide() {
            currentIndex = (currentIndex + 1) % images.length;
            showSlide(currentIndex);
        }

        // Función para ir a la imagen anterior
        function prevSlide() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showSlide(currentIndex);
        }

        // Botones de navegación
        const nextButton = carousel.parentNode.querySelector(".next");
        const prevButton = carousel.parentNode.querySelector(".prev");

        if (nextButton) nextButton.addEventListener("click", nextSlide);
        if (prevButton) prevButton.addEventListener("click", prevSlide);

        // Inicializa el carrusel mostrando la primera imagen
        showSlide(currentIndex);
    });
});
    