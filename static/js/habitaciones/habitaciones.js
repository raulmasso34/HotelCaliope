document.addEventListener('DOMContentLoaded', function () {
  const containers = document.querySelectorAll('.swiper-container');
  containers.forEach(container => {
      const swiperWrapper = container.querySelector('.swiper-wrapper');
      const slides = container.querySelectorAll('.swiper-slide');
      const totalSlides = slides.length;
      const visibleSlides = 3;  // Número de habitaciones visibles a la vez
      let currentIndex = 0;

      // Función para mover el carrusel hacia la izquierda
      const moveLeft = () => {
          if (currentIndex > 0) {
              currentIndex--;
          } else {
              currentIndex = totalSlides - visibleSlides;  // Vuelve al final
          }
          updateCarousel();
      };

      // Función para mover el carrusel hacia la derecha
      const moveRight = () => {
          if (currentIndex < totalSlides - visibleSlides) {
              currentIndex++;
          } else {
              currentIndex = 0;  // Vuelve al principio
          }
          updateCarousel();
      };

      // Función para actualizar el desplazamiento del carrusel
      const updateCarousel = () => {
          swiperWrapper.style.transform = `translateX(-${(currentIndex * 100) / visibleSlides}%)`;
      };

      // Agregar eventos a los botones de navegación
      container.querySelector('.swiper-button-prev').addEventListener('click', moveLeft);
      container.querySelector('.swiper-button-next').addEventListener('click', moveRight);
  });
});


const faqQuestions = document.querySelectorAll('.faq-question');

faqQuestions.forEach(question => {
    question.addEventListener('click', function() {
        const answer = this.nextElementSibling;

        // Si la respuesta está visible, la ocultamos
        if (answer.style.display === 'block') {
            answer.style.display = 'none';
        } else {
            // Ocultar todas las respuestas antes de mostrar la seleccionada
            document.querySelectorAll('.faq-answer').forEach(ans => {
                ans.style.display = 'none';
            });
            // Mostrar la respuesta seleccionada
            answer.style.display = 'block';
        }
    });
});




