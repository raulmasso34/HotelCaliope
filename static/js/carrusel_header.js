const images = [
    '../img/hotel1.jpg',
    '../img/hotel2.jpg',
    '../img/hotel3.jpg'
  ];
  
  let currentIndex = 0;
  
  function changeBackgroundImage() {
    const background = document.querySelector('.background-carousel::before');
    currentIndex = (currentIndex + 1) % images.length;
    background.style.backgroundImage = `url(${images[currentIndex]})`;
  }
  
  // Cambia de imagen cada 5 segundos
setInterval(changeBackgroundImage, 5000);