window.addEventListener('DOMContentLoaded', () => {
  // Función para inicializar un carrusel dado un ID específico
  const initializeCarousel = (carouselId, rightBtnId, leftBtnId, pictures) => {
    const img = document.getElementById(carouselId);
    const rightBtn = document.getElementById(rightBtnId);
    const leftBtn = document.getElementById(leftBtnId);
    let position = 0;

    // Configurar la primera imagen
    img.src = pictures[position];

    const moveRight = () => {
      position = (position + 1) % pictures.length; // Incrementa y reinicia si es necesario
      img.src = pictures[position];
    };

    const moveLeft = () => {
      position = (position - 1 + pictures.length) % pictures.length; // Decrementa y reinicia si es necesario
      img.src = pictures[position];
    };

    // Asociar los eventos de los botones
    rightBtn.addEventListener('click', moveRight);
    leftBtn.addEventListener('click', moveLeft);
  };

  // Detectar todos los carruseles en la página
  const carousels = document.querySelectorAll('[id^="carousel"]');
  
  carousels.forEach((carousel, index) => {
    const carouselId = carousel.id;
    const rightBtnId = `right-btn${index + 1}`;
    const leftBtnId = `left-btn${index + 1}`;

    // Las imágenes serán diferentes dependiendo de la página o de la variable que quieras usar
    let pictures = [];
    switch (carouselId) {
      case 'carousel1':
        pictures = [
          '../../../static/img/florida/florida1.jpg',
          '../../../static/img/florida/florida2.jpg',
        ];
        break;
      case 'carousel2':
        pictures = [
          '../../../static/img/europa/pirineos.jpg',
          '../../../static/img/florida/florida4.jpg',
        ];
        break;
      case 'carousel6':
        pictures = [
          '../../../static/img/ny/ny4.jpg',
          '../../../static/img/ny/ny5.jpg',
        ];
        break;
      // Agregar más casos según sea necesario
    }

    // Inicializar el carrusel con las imágenes correspondientes
    initializeCarousel(carouselId, rightBtnId, leftBtnId, pictures);
  });
});
