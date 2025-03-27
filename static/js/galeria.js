document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const modal = document.getElementById('hotelModal');
    const closeBtn = document.querySelector('.close');
    let currentSlide = 0;
    let slideInterval;
    const slideDuration = 5000;

    // 1. Funcionalidad de Filtrado
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

    // 2. Carrusel Modal
    function initModalCarousel() {
        document.querySelectorAll('.view-more').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const nombreArchivo = this.dataset.nombreArchivo;
                const directorio = this.dataset.directorio;
                
                loadCarouselImages(nombreArchivo, directorio);
                modal.style.display = 'block';
                startSlideShow();
            });
        });
    }

    function loadCarouselImages(nombreArchivo, directorio) {
        const images = [
            `../../static/img/${directorio}/${nombreArchivo}.jpg`,
            `../../static/img/${directorio}/${nombreArchivo}1.jpg`,
            `../../static/img/${directorio}/${nombreArchivo}2.jpg`,
            `../../static/img/${directorio}/${nombreArchivo}3.jpg`
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
            imgElement.alt = "Imágenes del hotel";
            imgElement.classList.add('carousel-item');
            if(index === 0) imgElement.classList.add('active');
            
            // Crear puntos de navegación
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if(index === 0) dot.classList.add('active');
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
        if(slideInterval) clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            moveSlide(1);
        }, slideDuration);
    }

    function resetSlideShow() {
        startSlideShow();
    }

    // 3. Cerrar Modal
    function initModalClose() {
        closeBtn.onclick = () => {
            modal.style.display = 'none';
            clearInterval(slideInterval);
        };
        
        window.onclick = (e) => {
            if(e.target === modal) {
                modal.style.display = 'none';
                clearInterval(slideInterval);
            }
        };
    }

    // 4. Otras Funcionalidades
    function initSmoothScroll() {
        const scrollArrow = document.querySelector('.scroll-down-arrow');
        if (scrollArrow) {
            scrollArrow.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: window.innerHeight * 0.95,
                    behavior: 'smooth'
                });
            });
        }
    }

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