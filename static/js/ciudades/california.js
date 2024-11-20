const carouselImages = document.querySelector('.carousel-images');
const images = document.querySelectorAll('.carousel-images img');
let currentIndex = 0;

function nextImage() {
  currentIndex = (currentIndex + 1) % images.length;
  const offset = -currentIndex * 100;
  carouselImages.style.transform = `translateX(${offset}%)`;
}

setInterval(nextImage, 3000); // Cambia cada 3 segundos





// Seleccionar elementos
const mainImage = document.querySelector('.main-image');
const thumbnails = document.querySelectorAll('.gallery-mini');

// Agregar evento a cada miniatura
thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
        // Cambiar la fuente de la imagen principal
        mainImage.src = thumbnail.src;

        // Remover estilos activos de otras miniaturas
        thumbnails.forEach(thumb => thumb.classList.remove('active-thumbnail'));

        // Agregar clase activa a la miniatura seleccionada
        thumbnail.classList.add('active-thumbnail');
    });
});
