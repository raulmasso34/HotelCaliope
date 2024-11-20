const carouselImages = document.querySelector('.carousel-images');
const images = document.querySelectorAll('.carousel-images img');
let currentIndex = 0;

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    const offset = -currentIndex * 100; // Calcula el desplazamiento
    carouselImages.style.transform = `translateX(${offset}%)`;
}

setInterval(nextImage, 3000);