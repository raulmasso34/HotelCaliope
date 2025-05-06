document.addEventListener('DOMContentLoaded', () => {
    // Main-up
    const mainUp = document.querySelector('.main-up');
    if (mainUp) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > window.innerHeight) {
                mainUp.classList.add('scrolled');
                mainUp.classList.remove('transparent');
            } else {
                mainUp.classList.add('transparent');
                mainUp.classList.remove('scrolled');
            }
        });
    }

    // Observador de la visibilidad de las secciones
    const sections = ['.main-main', '.dispo', '.servicios', '.ofertas', '.mapa-galicia'];
    sections.forEach(sectionSelector => {
        const section = document.querySelector(sectionSelector);
        if (section) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        section.classList.add('visible');
                        observer.unobserve(section);
                    }
                });
            }, {
                threshold: 0.4
            });
            observer.observe(section);
        }
    });

    // Carrusel de opiniones
    const opinions = document.querySelectorAll('.opinion');
    const dots = document.querySelectorAll('.dot');
    let opinionIndex = 0;

    function showOpinion(index) {
        opinions.forEach((opinion, i) => {
            opinion.classList.remove('active');
            dots[i].classList.remove('active');
            if (i === index) {
                opinion.classList.add('active');
                dots[i].classList.add('active');
            }
        });
    }

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            opinionIndex = i;
            showOpinion(opinionIndex);
        });
    });

    showOpinion(opinionIndex);

    // Iniciar el carrusel de fondo
    let currentIndex = 0;
    const backgrounds = document.querySelectorAll('.carousel-background');
    function changeBackground() {
        if (backgrounds.length > 0) {
            backgrounds[currentIndex].style.opacity = 0;
            currentIndex = (currentIndex + 1) % backgrounds.length;
            backgrounds[currentIndex].style.opacity = 1;
        }
    }
    setInterval(changeBackground, 3500);
});


var map = L.map('map').setView([40.70, -73.9], 13.499);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 100,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


var marker = L.marker([40.70, -73.9]).addTo(map);





window.addEventListener('DOMContentLoaded', () => {
  const initializeCarousel = (imgId, rightBtnId, leftBtnId, pictures) => {
    const img = document.getElementById(imgId);
    const rightBtn = document.getElementById(rightBtnId);
    const leftBtn = document.getElementById(leftBtnId);
    
    if (!img || !rightBtn || !leftBtn) {
      console.error(`Elementos no encontrados para el carrusel ${imgId}`);
      return;
    }

    let position = 0;

    // Mostrar primera imagen inmediatamente
    if (pictures.length > 0) {
      img.src = pictures[position];
    } else {
      console.error(`No hay imágenes definidas para ${imgId}`);
    }

    const moveRight = () => {
      position = (position + 1) % pictures.length;
      img.src = pictures[position];
    };

    const moveLeft = () => {
      position = (position - 1 + pictures.length) % pictures.length;
      img.src = pictures[position];
    };

    rightBtn.addEventListener('click', moveRight);
    leftBtn.addEventListener('click', moveLeft);
  };

  // Inicializamos los carruseles
  initializeCarousel('carousel1', 'right-btn1', 'left-btn1', [
    '../../../static/img/ny/ny.jpg',
    '../../../static/img/ny/ny9.jpg',
    // Asegúrate que estas rutas son correctas
  ]);

  initializeCarousel('carousel2', 'right-btn2', 'left-btn2', [
    '../../../static/img/ny/ny7.jpg',
    '../../../static/img/ny/ny8.jpg',
    // Asegúrate que estas rutas son correctas
  ]);
  
  // Eliminé el tercer carrusel que no existe en el HTML
});



// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    const scrollArrow = document.querySelector('.scroll-down-arrow'); // Selecciona el enlace de la flecha

    // Cuando se hace clic en la flecha
    scrollArrow.addEventListener('click', (event) => {
        event.preventDefault();  // Previene la acción por defecto del enlace (para no saltar instantáneamente)

        const targetSection = document.getElementById('stars-main');  // Sección a la que deseas desplazarte
        
        // Desplazarse suavemente a la sección objetivo
        targetSection.scrollIntoView({
            behavior: 'smooth',  // Efecto de desplazamiento suave
            block: 'start'       // Alinea la parte superior de la sección con la parte superior de la ventana
        });
    });
});
