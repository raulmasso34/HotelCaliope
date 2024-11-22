document.addEventListener('DOMContentLoaded', () => {
    const carouselImages = document.querySelector('.carousel-images');
    const images = document.querySelectorAll('.carousel-images img');
    let currentIndex = 0;

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        const offset = -currentIndex * 100; // Desplazamiento basado en el índice actual
        carouselImages.style.transform = `translateX(${offset}%)`;
    }

    setInterval(nextImage, 3000); // Cambiar imagen cada 3 segundos
});




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