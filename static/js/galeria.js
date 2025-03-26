document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sections = document.querySelectorAll('.gallery-section');
    const scrollArrow = document.querySelector('.scroll-down-arrow');
    const mobileMenuBtn = document.getElementById('menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const carousel = document.querySelectorAll('.carousel-background');

    // Función para el filtrado de la galería
    function initGalleryFilter() {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
    
                const filter = button.dataset.filter.toLowerCase();
    
                sections.forEach(section => {
                    const sectionFilter = section.classList.contains(filter);
                    const isAll = filter === 'all';
                    
                    section.style.display = isAll || sectionFilter ? 'block' : 'none';
                    
                    // Animación suave
                    if (section.style.display === 'block') {
                        section.style.animation = 'fadeIn 0.5s ease';
                    }
                });
            });
        });
    }
    // Función para el scroll suave
    function initSmoothScroll() {
        if (scrollArrow) {
            scrollArrow.addEventListener('click', function(e) {
                e.preventDefault();
                const viewportHeight = window.innerHeight;
                window.scrollTo({
                    top: viewportHeight * 0.95,
                    behavior: 'smooth'
                });
            });
        }
    }

    // Función para manejar la visibilidad de la flecha de scroll
    function handleScrollArrowVisibility() {
        if (scrollArrow) {
            window.addEventListener('scroll', function() {
                scrollArrow.style.opacity = window.scrollY > 100 ? '0' : '1';
                scrollArrow.style.transition = 'opacity 0.3s ease';
            });
        }
    }

    // Función para el carrusel de imágenes
    function initCarousel() {
        if (carousel.length > 1) {
            let currentIndex = 0;
            
            function nextImage() {
                carousel[currentIndex].style.opacity = '0';
                currentIndex = (currentIndex + 1) % carousel.length;
                carousel[currentIndex].style.opacity = '1';
            }

            // Cambiar imagen cada 5 segundos
            setInterval(nextImage, 5000);
        }
    }

    // Función para el menú móvil
    function initMobileMenu() {
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                mobileMenuBtn.classList.toggle('active');
            });

            // Cerrar menú al hacer click fuera
            document.addEventListener('click', (e) => {
                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                }
            });
        }
    }

    // Función para manejar animaciones de entrada
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observar elementos que queremos animar
        document.querySelectorAll('.hotel-card').forEach(card => {
            observer.observe(card);
        });
    }

    // Inicializar todas las funcionalidades
    function initializeAll() {
        initGalleryFilter();
        initSmoothScroll();
        handleScrollArrowVisibility();
        initCarousel();
        initMobileMenu();
        initScrollAnimations();
    }

    // Iniciar todo
    initializeAll();
});



document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('hotelModal');
    const closeBtn = document.querySelector('.close');
    
    // Manejador de clic para los enlaces "Ver hotel"
    document.querySelectorAll('.view-more').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const hotelId = this.dataset.hotelId;
            const directorio = this.dataset.directorio;
            
            // Cargar imágenes dinámicamente (ejemplo - adaptar a tu backend)
            const images = cargarImagenesHotel(hotelId, directorio);
            
            actualizarGaleria(images);
            modal.style.display = 'block';
        });
    });

    // Cerrar modal
    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (e) => e.target == modal ? modal.style.display = 'none' : null;

    function actualizarGaleria(imagenes) {
        const carousel = document.getElementById('galleryCarousel');
        carousel.innerHTML = '';
        imagenes.forEach(img => {
            const imgElement = document.createElement('img');
            imgElement.src = img;
            imgElement.alt = `Imagen del hotel`;
            carousel.appendChild(imgElement);
        });
    }

    function cargarImagenesHotel(hotelId, directorio) {
        // Esta función debe ser implementada según tu backend
        // Ejemplo estático:
        return [
            `../../static/img/${directorio}/hotel-${hotelId}-1.jpg`,
            `../../static/img/${directorio}/hotel-${hotelId}-2.jpg`,
            `../../static/img/${directorio}/hotel-${hotelId}-3.jpg`
        ];
    }
});