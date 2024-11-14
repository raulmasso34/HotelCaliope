const carouselImages = document.querySelector('.carousel-images');
const images = document.querySelectorAll('.carousel-images img');
let currentIndex = 0;

function nextImage() {
  currentIndex = (currentIndex + 1) % images.length;
  const offset = -currentIndex * 100;
  carouselImages.style.transform = `translateX(${offset}%)`;
}

setInterval(nextImage, 3000); // Cambia cada 3 segundos


const carouselImages1 = document.querySelector('.hoteles-img');
const images1 = document.querySelectorAll('.hoteles-img img');
let currentIndex1 = 0;

function nextImage() {
  currentIndex1 = (currentIndex1 + 1) % images.length;
  const offset = -currentIndex1 * 100;
  carouselImages1.style.transform = `translateX(${offset}%)`;
}

setInterval(nextImage, 3000); // Cambia cada 3 segundos

