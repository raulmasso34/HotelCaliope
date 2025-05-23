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


var map = L.map('map').setView([34, -118.2], 13.499);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 100,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([34, -118.2]).addTo(map);
window.addEventListener('DOMContentLoaded', () => {
    // Función para inicializar cada carrusel
    const initializeCarousel = (imgId, rightBtnId, leftBtnId, pictures) => {
      const img = document.getElementById(imgId);
      const rightBtn = document.getElementById(rightBtnId);
      const leftBtn = document.getElementById(leftBtnId);
      
      // Verificar que los elementos del carrusel existen
      if (!img || !rightBtn || !leftBtn) {
        console.error(`Elementos no encontrados para el carrusel con ID: ${imgId}`);
        return;
      }
  
      let position = 0;
  
      // Si hay imágenes, mostrar la primera inmediatamente
      if (pictures.length > 0) {
        img.src = pictures[position];
      } else {
        console.error(`No hay imágenes definidas para el carrusel con ID: ${imgId}`);
      }
  
      // Función para mover la imagen hacia la derecha
      const moveRight = () => {
        position = (position + 1) % pictures.length;  // Incrementa la posición, y vuelve al inicio si es necesario
        img.src = pictures[position];
      };
  
      // Función para mover la imagen hacia la izquierda
      const moveLeft = () => {
        position = (position - 1 + pictures.length) % pictures.length;  // Decrementa la posición, y vuelve al final si es necesario
        img.src = pictures[position];
      };
  
      // Asignar los eventos de clic para los botones de la flecha
      rightBtn.addEventListener('click', moveRight);
      leftBtn.addEventListener('click', moveLeft);
    };
  
    // Inicializamos los carruseles con las imágenes correspondientes
    initializeCarousel('carousel1', 'right-btn1', 'left-btn1', [
      '../../../static/img/pirineos/pirineos4.jpg',  // Asegúrate que estas rutas son correctas
      '../../../static/img/pirineos/pirineos5.png', 
      // Agrega más imágenes si es necesario
    ]);
  
    initializeCarousel('carousel2', 'right-btn2', 'left-btn2', [
      '../../../static/img/pirineos/pirineos2.jpg',
      '../../../static/img/pirineos/pirineos3.jpg', 
      // Agrega más imágenes si es necesario
    ]);
  });
  


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

/*MODAL */
document.addEventListener('DOMContentLoaded', function() {
  // Obtener elementos
  const modal = document.getElementById('hotelModal');
  const saberMasBtn = document.querySelector('.main-botones button:first-child');
  const closeBtn = document.querySelector('.close-btn');
  
  // Abrir modal al hacer clic en SABER MÁS
  saberMasBtn.addEventListener('click', function() {
      modal.style.display = 'block';
      setTimeout(() => {
          modal.classList.add('show');
      }, 10);
  });
  
  // Cerrar modal
  closeBtn.addEventListener('click', closeModal);
  
  // Cerrar al hacer clic fuera del modal
  window.addEventListener('click', function(event) {
      if (event.target === modal) {
          closeModal();
      }
  });
  
  function closeModal() {
      modal.classList.remove('show');
      setTimeout(() => {
          modal.style.display = 'none';
      }, 300);
  }
});

//menu hamburguesa

// JavaScript para mostrar/ocultar el menú hamburguesa
// Toggle the mobile menu when the menu-toggle is clicked
document.getElementById('menu-toggle').addEventListener('click', function() {
    document.querySelector('.mobile-menu').classList.toggle('active');
    this.classList.toggle('open'); // Agregar la clase 'open' para animar las barras del menú
});

// Toggle the dropdown menu inside mobile menu
document.querySelectorAll('.dropdown-mobile > a').forEach(item => {
    item.addEventListener('click', function(e) {
        const dropdownContent = item.nextElementSibling; // Contenido del dropdown
        dropdownContent.classList.toggle('open'); // Activar o desactivar el dropdown
        e.preventDefault(); // Evitar el comportamiento predeterminado de los enlaces
    });
});



/// Función para alternar el menú desplegable "dropdown-perfil"
function toggleDropPerfil() {
    var dropdownContent = document.querySelector(".dropdown-perfil-content");
    dropdownContent.classList.toggle("show");
}

// Cerrar el menú si el usuario hace clic fuera de él
window.onclick = function(event) {
    if (!event.target.matches('.icon-perfil') && !event.target.matches('.dropdown-perfil-content') && !event.target.matches('.dropdown-perfil')) {
        var dropdowns = document.getElementsByClassName("dropdown-perfil-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
