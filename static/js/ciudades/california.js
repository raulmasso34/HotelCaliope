let index = 0;

function moveSlide(direction) {
  const images = document.querySelectorAll('.carousel-images img');
  const totalImages = images.length;

  index = (index + direction + totalImages) % totalImages;
  const carousel = document.querySelector('.carousel-images');
  carousel.style.transform = `translateX(${-index * 100}%)`;
}
