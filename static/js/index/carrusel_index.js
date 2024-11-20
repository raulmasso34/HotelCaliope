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
