window.addEventListener('DOMContentLoaded', () => {
  const initializeCarousel = (imgId, rightBtnId, leftBtnId, pictures) => {
    const img = document.getElementById(imgId);
    const rightBtn = document.getElementById(rightBtnId);
    const leftBtn = document.getElementById(leftBtnId);
    let position = 0;

    img.src = pictures[position];

    const moveRight = () => {
      position = (position + 1) % pictures.length; // Incrementa y reinicia si es necesario
      img.src = pictures[position];
    };

    const moveLeft = () => {
      position = (position - 1 + pictures.length) % pictures.length; // Decrementa y reinicia si es necesario
      img.src = pictures[position];
    };

    rightBtn.addEventListener('click', moveRight);
    leftBtn.addEventListener('click', moveLeft);
  };

  // Inicializamos los carruseles
  initializeCarousel('carousel1', 'right-btn1', 'left-btn1', [
    '../../../static/img/florida/florida1.jpg',
    '../../../static/img/florida/florida2.jpg',
  ]);

  initializeCarousel('carousel2', 'right-btn2', 'left-btn2', [
    '../../../static/img/europa/pirineos.jpg',
    '../../../static/img/florida/florida4.jpg',
  ]);

  
});
