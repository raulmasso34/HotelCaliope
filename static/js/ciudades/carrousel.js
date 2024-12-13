window.addEventListener('DOMContentLoaded', () => {
    // Primer carrusel
    const img1 = document.getElementById('carousel1');
    const rightBtn1 = document.getElementById('right-btn1');
    const leftBtn1 = document.getElementById('left-btn1'); // Asegúrate de que el ID coincida
    let pictures1 = ['../../../static/img/florida/florida1.jpg', '../../../static/img/florida/florida2.jpg'];
    img1.src = pictures1[0];
    let position1 = 0;
  
    const moveRight1 = () => {
      if (position1 >= pictures1.length - 1) {
        position1 = 0;
      } else {
        position1++;
      }
      img1.src = pictures1[position1];
    };
  
    const moveLeft1 = () => {
      if (position1 <= 0) {
        position1 = pictures1.length - 1;
      } else {
        position1--;
      }
      img1.src = pictures1[position1];
    };
  
    rightBtn1.addEventListener("click", moveRight1);
    leftBtn1.addEventListener("click", moveLeft1);
  
    // Segundo carrusel
    const img2 = document.getElementById('carousel2');
    const rightBtn2 = document.getElementById('right-btn2');
    const leftBtn2 = document.getElementById('left-btn2');
    let pictures2 = ['../../../static/img/florida/florida3.jpg', '../../../static/img/florida/florida4.jpg'];
    img2.src = pictures2[0];
    let position2 = 0;
  
    const moveRight2 = () => {
      if (position2 >= pictures2.length - 1) {
        position2 = 0;
      } else {
        position2++;
      }
      img2.src = pictures2[position2];
    };
  
    const moveLeft2 = () => {
      if (position2 <= 0) {
        position2 = pictures2.length - 1;
      } else {
        position2--;
      }
      img2.src = pictures2[position2];
    };
  
    rightBtn2.addEventListener("click", moveRight2);
    leftBtn2.addEventListener("click", moveLeft2);
  });
  