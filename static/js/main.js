// Selecciona el elemento main-up
const mainUp = document.querySelector('.main-up');

// Escucha el evento de desplazamiento
window.addEventListener('scroll', () => {
    // Detecta la posición de scroll
    if (window.scrollY > window.innerHeight) {
        // Si estamos más abajo que la imagen, aplica el fondo blanco
        mainUp.classList.add('scrolled');
        mainUp.classList.remove('transparent');
    } else {
        // Si estamos sobre la imagen, mantén el fondo transparente
        mainUp.classList.add('transparent');
        mainUp.classList.remove('scrolled');
    }
});


  
document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("privacy-banner");
    const acceptButton = document.getElementById("accept-btn");
  
    // Verifica si el usuario ya aceptó la política
    if (localStorage.getItem("privacyAccepted") === "true") {
      banner.style.display = "none";  // Oculta el banner si ya aceptó
    }
  
    acceptButton.addEventListener("click", function () {
      banner.style.opacity = '0';  // Comienza el desvanecimiento
      banner.style.visibility = 'hidden';
      setTimeout(() => {
        banner.style.display = 'none';  // Finalmente quita el banner
      }, 600);
      
      // Guarda la preferencia del usuario
      localStorage.setItem("privacyAccepted", "true");
    });
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



// CARRUSEL PRINCIPAL

let currentIndex = 0;
const backgrounds = document.querySelectorAll('.carousel-background'); // Selecciona todas las imágenes de fondo

// Función para cambiar el fondo
function changeBackground() {
    // Ocultar la imagen actual
    backgrounds[currentIndex].style.opacity = 0;
    
    // Avanzar al siguiente fondo, asegurándonos de que sea cíclico
    currentIndex = (currentIndex + 1) % backgrounds.length;
    
    // Mostrar la siguiente imagen
    backgrounds[currentIndex].style.opacity = 1;
}

// Iniciar el carrusel con un intervalo de 5 segundos
function startBackgroundCarousel() {
    setInterval(changeBackground, 3500); // Cambiar cada 5 segundos
}

// Iniciar el carrusel de fondo cuando la página cargue
window.onload = startBackgroundCarousel;


// SCROLL EFECTO
document.addEventListener('DOMContentLoaded', () => {
    const mainSection = document.querySelector('.main-main');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                mainSection.classList.add('visible');
                observer.unobserve(mainSection); // Deja de observar después de activar la animación
            }
        });
    }, {
        threshold: 0.4  // Se activa cuando el 30% del elemento es visible
    });

    observer.observe(mainSection);
});

// SLIDER DE HABITACIONES

document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('habitacionesSlider');
    const prevBtn = document.querySelector('.habitaciones-btn.prev');
    const nextBtn = document.querySelector('.habitaciones-btn.next');
    const cards = document.querySelectorAll('.habitacion-card');
    let currentIndex = 0;
    const cardWidth = cards[0].offsetWidth + 30; // Ancho de la tarjeta + gap
  
    // Función para mover el slider
    function moveSlider(direction) {
      const cardsVisible = Math.floor(slider.offsetWidth / cardWidth);
      const maxIndex = cards.length - cardsVisible;
      
      if (direction === 'next') {
        currentIndex = Math.min(currentIndex + 1, maxIndex);
      } else {
        currentIndex = Math.max(currentIndex - 1, 0);
      }
      
      slider.scrollTo({
        left: currentIndex * cardWidth,
        behavior: 'smooth'
      });
      
      // Actualizar visibilidad de botones
      prevBtn.style.display = currentIndex === 0 ? 'none' : 'block';
      nextBtn.style.display = currentIndex >= maxIndex ? 'none' : 'block';
    }
  
    // Event listeners para los botones
    prevBtn.addEventListener('click', () => moveSlider('prev'));
    nextBtn.addEventListener('click', () => moveSlider('next'));
  
    // Ocultar/mostrar botones según la posición inicial
    function updateButtons() {
      const cardsVisible = Math.floor(slider.offsetWidth / cardWidth);
      const maxIndex = cards.length - cardsVisible;
      
      prevBtn.style.display = currentIndex === 0 ? 'none' : 'block';
      nextBtn.style.display = currentIndex >= maxIndex ? 'none' : 'block';
    }
  
    // Actualizar en resize
    window.addEventListener('resize', function() {
      cardWidth = cards[0].offsetWidth + 30;
      updateButtons();
    });
  
    // Inicializar
    updateButtons();
  });


document.addEventListener('DOMContentLoaded', () => {
    const opinions = document.querySelectorAll('.opinion'); // Todas las opiniones
    const dots = document.querySelectorAll('.dot');        // Todos los puntos

    let opinionIndex = 0; // Índice actual de la opinión

    // Función para mostrar la opinión activa
    function showOpinion(index) {
        opinions.forEach((opinion, i) => {
            opinion.classList.remove('active'); // Remover la clase activa de todas las opiniones
            dots[i].classList.remove('active'); // Remover la clase activa de todos los puntos
            if (i === index) {
                opinion.classList.add('active'); // Añadir la clase activa a la opinión actual
                dots[i].classList.add('active'); // Añadir la clase activa al punto actual
            }
        });
    }

    // Evento para cada punto
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            opinionIndex = i; // Actualizar el índice al que corresponde el punto
            showOpinion(opinionIndex);
        });
    });

    // Inicializa la primera opinión como activa
    showOpinion(opinionIndex);
});


var map = L.map('map').setView([41.545, 1.8], 2.499);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([42.74, 1.1]).addTo(map);//Pirineos
var marker = L.marker([40.70, -73.9]).addTo(map);//Nueva York
var marker = L.marker([42.879, -8]).addTo(map);//galicia
var marker = L.marker([26, -80.2]).addTo(map);//Florida
var marker = L.marker([34, -118.2]).addTo(map);//Los Angeles
var marker = L.marker([41.7214, 2.936]).addTo(map);//Tossa


document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todas las cajas de beneficios
    const benSubElements = document.querySelectorAll('.ben-sub');
    
    // Crear un observer para detectar cuando los elementos entren en el viewport
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Cuando el elemento es visible, agregar una clase para animarlo
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Deja de observar el elemento después de que se ha mostrado
            }
        });
    }, {
        threshold: 0.5 // Activar cuando el 50% del elemento sea visible
    });
    
    // Comenzar a observar cada caja de beneficio
    benSubElements.forEach(benSub => {
        observer.observe(benSub);
    });
});



//OPINIONES

document.addEventListener('DOMContentLoaded', function() {
    // Establecer el primer testimonio como activo al inicio
    const allTestimonials = document.querySelectorAll('.testimonial');
    if (allTestimonials.length > 0) {
      allTestimonials[0].classList.add('active');
    }
    
    const prevButton = document.querySelector('.carousel-arrow.prev');
    const nextButton = document.querySelector('.carousel-arrow.next');
    const dots = document.querySelectorAll('.nav-dot');
    
    let currentIndex = 0;
    const totalTestimonials = allTestimonials.length;
    
    // Función para mostrar un testimonio específico
    function showTestimonial(index) {
      // Ocultar todos los testimonios
      allTestimonials.forEach(testimonial => {
        testimonial.classList.remove('active');
      });
      
      // Mostrar el testimonio actual
      allTestimonials[index].classList.add('active');
      
      // Actualizar puntos de navegación
      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
    }
    
    // Evento para el botón anterior
    if (prevButton) {
      prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalTestimonials) % totalTestimonials;
        showTestimonial(currentIndex);
      });
    }
    
    // Evento para el botón siguiente
    if (nextButton) {
      nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalTestimonials;
        showTestimonial(currentIndex);
      });
    }
    
    // Evento para los puntos de navegación
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        currentIndex = index;
        showTestimonial(currentIndex);
      });
    });
    
    // Autoplay (opcional)
    let autoplayInterval = setInterval(() => {
      currentIndex = (currentIndex + 1) % totalTestimonials;
      showTestimonial(currentIndex);
    }, 5000);
    
    // Pausar autoplay al hover
    const carousel = document.querySelector('.testimonials-carousel');
    if (carousel) {
      carousel.addEventListener('mouseenter', () => {
        clearInterval(autoplayInterval);
      });
      
      carousel.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(() => {
          currentIndex = (currentIndex + 1) % totalTestimonials;
          showTestimonial(currentIndex);
        }, 5000);
      });
    }
    
    // Efecto parallax al hacer scroll
    const testimonialSection = document.querySelector('.testimonials-section');
    
    window.addEventListener('scroll', () => {
      if (!testimonialSection) return;
      
      const scrollPosition = window.pageYOffset;
      const sectionTop = testimonialSection.offsetTop;
      const sectionHeight = testimonialSection.offsetHeight;
      
      // Verificar si la sección está visible
      if (scrollPosition + window.innerHeight > sectionTop && 
          scrollPosition < sectionTop + sectionHeight) {
        // Calcular posición del parallax
        const yPos = (scrollPosition - sectionTop) * 0.3;
        document.documentElement.style.setProperty('--parallax-y', `${yPos}px`);
      }
    });
  });


  //--------------------MODAL DE HOTELES VER MAS BOTON-------------------------
  // Obtener el modal
var modal = document.getElementById("hotelModal");

// Obtener el botón que abre el modal
var btns = document.querySelectorAll('.ver-mas-btn');

// Obtener el <span> que cierra el modal
var span = document.getElementsByClassName("close-btn")[0];

// Agregar un evento a cada botón "VER MÁS"
// Modificación para añadir animación al abrir/cerrar
// Función para abrir el modal
function openModal(btn) {
  // Rellenar datos básicos
  document.getElementById("modal-name").innerText = btn.getAttribute('data-nombre');
  document.getElementById("modal-description").innerText = btn.getAttribute('data-descripcion');
  document.getElementById("modal-image").src = btn.getAttribute('data-imagen');
  document.getElementById("modal-city").innerText = btn.getAttribute('data-ciudad');
  
  // Formatear estrellas
  const starsCount = parseInt(btn.getAttribute('data-estrellas'));
  document.getElementById("modal-stars").innerHTML = '★'.repeat(starsCount) + '☆'.repeat(5-starsCount);
  
  // Formatear servicios como tags
  const servicios = btn.getAttribute('data-servicios').split(',');
  const servicesContainer = document.getElementById("modal-services");
  servicesContainer.innerHTML = '';
  
  servicios.forEach(servicio => {
    if (servicio.trim() !== '') {
      const tag = document.createElement('span');
      tag.textContent = servicio.trim();
      servicesContainer.appendChild(tag);
    }
  });
  
  // Mostrar modal con animación
  modal.style.display = "block";
  setTimeout(() => {
    modal.classList.add('show');
  }, 10);
}

// Función para cerrar el modal
function closeModal() {
  modal.classList.remove('show');
  setTimeout(() => {
    modal.style.display = "none";
  }, 300);
}

// Event listeners
document.querySelectorAll('.ver-mas-btn').forEach(btn => {
  btn.addEventListener('click', () => openModal(btn));
});

document.querySelector('.close-btn').addEventListener('click', closeModal);

window.addEventListener('click', (e) => {
  if (e.target === modal) {
    closeModal();
  }
});