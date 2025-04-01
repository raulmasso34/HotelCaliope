document.addEventListener('DOMContentLoaded', () => {
    let currentSlide = 0;
    let slideInterval;
    const modal = document.querySelector('.room-modal');
    const closeBtn = document.querySelector('.close-modal');

    // Delegación de eventos para abrir modal
    document.querySelector('.rooms-grid').addEventListener('click', (e) => {
        const detailsBtn = e.target.closest('.view-details');
        if (detailsBtn) {
            const card = detailsBtn.closest('.room-card');
            showRoomDetails(card);
        }
    });

    function showRoomDetails(card) {
        try {
            const datos = {
                tipo: card.dataset.tipo,
                precio: parseFloat(card.dataset.precio).toFixed(2),
                descripcion: card.dataset.descripcion,
                capacidad: card.dataset.capacidad,
                servicios: JSON.parse(card.dataset.servicios),
                imagenes: JSON.parse(card.dataset.imagenes)
            };

            // Actualizar elementos del modal
            document.querySelector('.modal-title').textContent = `Habitación ${datos.tipo}`;
            document.querySelector('.modal-price').textContent = `$${datos.precio}`;
            document.querySelector('.modal-capacity').textContent = datos.capacidad;
            document.querySelector('.modal-description').textContent = datos.descripcion;

            // Actualizar servicios
            const serviciosHTML = datos.servicios.map(s => `
                <li>
                    <i class="fas fa-check-circle"></i>
                    ${s.trim()}
                </li>
            `).join('') || '<li>No hay servicios adicionales</li>';
            
            document.querySelector('.services-list').innerHTML = serviciosHTML;

            // Inicializar carrusel
            initCarousel(datos.imagenes);
            
            // Mostrar modal
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        } catch (error) {
            console.error('Error al mostrar detalles:', error);
        }
    }

    function initCarousel(images) {
        const carousel = document.querySelector('.carousel-inner');
        const dotsContainer = document.querySelector('.carousel-dots');
        
        // Limpiar contenido previo
        carousel.innerHTML = '';
        dotsContainer.innerHTML = '';

        // Validar y asegurar al menos una imagen
        const validImages = images.length > 0 ? images : ['../../static/img/habitaciones/default.jpg'];

        // Generar slides
        validImages.forEach((img, index) => {
            carousel.insertAdjacentHTML('beforeend', `
                <img src="${img}" 
                     class="${index === 0 ? 'active' : ''}" 
                     alt="Vista de la habitación"
                     loading="lazy">
            `);

            dotsContainer.insertAdjacentHTML('beforeend', `
                <button class="dot ${index === 0 ? 'active' : ''}" 
                        data-index="${index}"
                        aria-label="Slide ${index + 1}"></button>
            `);
        });

        // Configurar eventos
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');
        
        const navHandler = (direction) => {
            moveSlide(direction);
            resetSlideShow();
        };

        prevBtn.addEventListener('click', () => navHandler(-1));
        nextBtn.addEventListener('click', () => navHandler(1));
        
        document.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', () => {
                showSlide(parseInt(dot.dataset.index));
                resetSlideShow();
            });
        });

        startSlideShow();
    }

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-inner img');
        const dots = document.querySelectorAll('.dot');
        
        currentSlide = (index + slides.length) % slides.length;
        
        slides.forEach((slide, i) => 
            slide.classList.toggle('active', i === currentSlide));
        
        dots.forEach((dot, i) => 
            dot.classList.toggle('active', i === currentSlide));
    }

    function moveSlide(direction) {
        const slides = document.querySelectorAll('.carousel-inner img');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    function startSlideShow() {
        if (slideInterval) clearInterval(slideInterval);
        slideInterval = setInterval(() => moveSlide(1), 8000);
    }

    function resetSlideShow() {
        startSlideShow();
    }

    // Cerrar modal
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        clearInterval(slideInterval);
    }

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Mejorar accesibilidad
    window.addEventListener('keyup', (e) => {
        if (e.key === 'Escape') closeModal();
    });
});