// ------------------------------
    // Carrusel de Habitaciones
    // ------------------------------
    document.addEventListener("DOMContentLoaded", function () {
        let currentSlide = 0;
        const slides = document.querySelectorAll(".carousel-slide");
        const totalSlides = slides.length;
        const nextBtn = document.querySelector(".carousel-control.next");
        const prevBtn = document.querySelector(".carousel-control.prev");
  
        function showSlide(index) {
          slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
          });
        }
  
        nextBtn.addEventListener("click", function () {
          currentSlide = (currentSlide + 1) % totalSlides;
          showSlide(currentSlide);
        });
  
        prevBtn.addEventListener("click", function () {
          currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
          showSlide(currentSlide);
        });
      });
  
      // ------------------------------
      // Acordeón para FAQ
      // ------------------------------
      document.addEventListener("DOMContentLoaded", function () {
        const faqItems = document.querySelectorAll(".faq-item");
        faqItems.forEach((item) => {
          const question = item.querySelector("h3");
          question.addEventListener("click", function () {
            item.classList.toggle("active");
            const answer = item.querySelector("p");
            answer.style.display = answer.style.display === "block" ? "none" : "block";
          });
        });
      });