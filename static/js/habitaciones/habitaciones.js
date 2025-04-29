document.addEventListener('DOMContentLoaded', function () {
    // Variables globales
    const modal = document.getElementById('habitacionModal');
    const closeBtn = document.querySelector('.close');
    let currentSlide = 0;
    let slideInterval;
    const slideDuration = 5000;

    // Filtro de continentes y tipos de habitación
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sections = document.querySelectorAll('.gallery-section');

    function initGalleryFilter() {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.dataset.filter.toLowerCase();

                sections.forEach(section => {
                    const sectionFilter = section.classList.contains(filter);
                    section.style.display = (filter === 'all' || sectionFilter) ? 'block' : 'none';

                    if (section.style.display === 'block') {
                        section.style.animation = 'fadeIn 0.5s ease';
                    }
                });
            });
        });
    }

    // Modal y Carrusel
    function initModalCarousel() {
        document.querySelectorAll('.view-more').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const tipoHabitacion = this.dataset.tipoHabitacion;
                const directorio = 'habitaciones';

                loadCarouselImages(tipoHabitacion, directorio);
                modal.style.display = 'block';
                startSlideShow();
            });
        });
    }

    function loadCarouselImages(tipoHabitacion, directorio) {
        const images = [
            `../../static/img/${directorio}/${tipoHabitacion}.jpg`,
            `../../static/img/${directorio}/${tipoHabitacion}1.jpg`,
            `../../static/img/${directorio}/${tipoHabitacion}2.jpg`,
            `../../static/img/${directorio}/${tipoHabitacion}3.jpg`
        ];

        const validImages = images.filter(img => {
            const imgElement = new Image();
            imgElement.src = img;
            return new Promise(resolve => {
                imgElement.onload = () => resolve(true);
                imgElement.onerror = () => resolve(false);
            });
        });

        initCarousel(validImages);
    }

    function initCarousel(images) {
        const carousel = document.getElementById('galleryCarousel');
        const dotsContainer = document.getElementById('carouselDots');

        // Limpiar contenido previo
        carousel.innerHTML = '';
        dotsContainer.innerHTML = '';

        images.forEach((img, index) => {
            // Crear elementos de imagen
            const imgElement = document.createElement('img');
            imgElement.src = img;
            imgElement.alt = "Imágenes de la habitación";
            imgElement.classList.add('carousel-item');
            if (index === 0) imgElement.classList.add('active');

            // Crear puntos de navegación
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => showSlide(index));

            // Añadir al DOM
            carousel.appendChild(imgElement);
            dotsContainer.appendChild(dot);
        });

        // Eventos de flechas
        document.querySelectorAll('.carousel-arrow').forEach(arrow => {
            arrow.addEventListener('click', (e) => {
                const direction = e.target.classList.contains('next') ? 1 : -1;
                moveSlide(direction);
                resetSlideShow();
            });
        });
    }

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.dot');

        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === currentSlide);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentSlide);
        });
    }

    function moveSlide(direction) {
        const slides = document.querySelectorAll('.carousel-item');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    function startSlideShow() {
        if (slideInterval) clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            moveSlide(1);
        }, slideDuration);
    }

    function resetSlideShow() {
        startSlideShow();
    }

    // Cerrar Modal
    function initModalClose() {
        closeBtn.onclick = () => {
            modal.style.display = 'none';
            clearInterval(slideInterval);
        };

        window.onclick = (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                clearInterval(slideInterval);
            }
        };
    }

    // Otras Funcionalidades
    document.addEventListener('DOMContentLoaded', function () {
        const scrollArrow = document.querySelector('.scroll-down-arrow');
    
        if (scrollArrow) {
            scrollArrow.addEventListener('click', function (e) {
                e.preventDefault();
                const targetSection = document.querySelector('#gallery-section');
                if (targetSection) {
                    slowScrollTo(targetSection.offsetTop, 1500); // 1500 ms (1.5 segundos)
                }
            });
        }
    
        function slowScrollTo(targetPosition, duration) {
            const startPosition = window.scrollY;
            const distance = targetPosition - startPosition;
            const startTime = performance.now();
    
            function animation(currentTime) {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1);
                window.scrollTo(0, startPosition + distance * easeOutQuad(progress));
    
                if (progress < 1) {
                    requestAnimationFrame(animation);
                }
            }
    
            function easeOutQuad(t) {
                return t * (2 - t); // Función de easing para un desplazamiento suave
            }
    
            requestAnimationFrame(animation);
        }
    });
    
    

    function initMobileMenu() {
        const mobileMenuBtn = document.getElementById('menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                mobileMenuBtn.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                }
            });
        }
    }

    // Inicialización General
    function initializeAll() {
        initGalleryFilter();
        initModalCarousel();
        initModalClose();
        initSmoothScroll();
        initMobileMenu();
    }

    initializeAll();
});



