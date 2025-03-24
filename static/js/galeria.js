document.addEventListener('DOMContentLoaded', function () {
    // Botones de filtro
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryGrid = document.querySelector('.gallery-grid');
    const hotelSections = document.querySelectorAll('.hotel-section');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remover la clase "active" de todos los botones
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const filterValue = button.getAttribute('data-filter');

            // Cambiar la disposición de la galería
            if (filterValue === 'all') {
                galleryGrid.classList.add('gallery-all');
            } else {
                galleryGrid.classList.remove('gallery-all');
            }

            // Filtrar hoteles
            hotelSections.forEach(section => {
                if (filterValue === 'all' || section.classList.contains(filterValue)) {
                    section.style.display = 'block';
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        section.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // ===========================
    //  Modal de Imágenes
    // ===========================
    const galleryItems = document.querySelectorAll('.gallery-item');
    let currentImageIndex = 0;
    let images = [];

    // Crear elementos del modal
    const modal = document.createElement('div');
    modal.className = 'gallery-modal';
    modal.innerHTML = `
        <span class="modal-close">&times;</span>
        <img class="modal-image" src="" alt="Gallery Image">
        <button class="modal-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="modal-next"><i class="fas fa-chevron-right"></i></button>
        <div class="modal-caption"></div>
    `;
    document.body.appendChild(modal);

    // Elementos del modal
    const modalImage = modal.querySelector('.modal-image');
    const modalClose = modal.querySelector('.modal-close');
    const modalPrev = modal.querySelector('.modal-prev');
    const modalNext = modal.querySelector('.modal-next');
    const modalCaption = modal.querySelector('.modal-caption');

    // Abrir el modal
    function openModal(index) {
        currentImageIndex = index;
        modal.style.display = 'flex';
        updateModalImage();
        document.body.style.overflow = 'hidden';
        setTimeout(() => modal.style.opacity = '1', 10);
    }

    // Cerrar el modal
    function closeModal() {
        modal.style.opacity = '0';
        document.body.style.overflow = '';
        setTimeout(() => modal.style.display = 'none', 300);
    }

    // Actualizar imagen del modal
    function updateModalImage() {
        const currentImage = images[currentImageIndex];
        modalImage.src = currentImage.src;
        modalCaption.innerHTML = `
            <h3>${currentImage.caption.title}</h3>
            <p>${currentImage.caption.location}</p>
        `;
    }

    // Recopilar imágenes y sus datos
    galleryItems.forEach((item, index) => {
        const img = item.querySelector('img');
        const overlay = item.querySelector('.gallery-overlay');
        images.push({
            src: img.src,
            caption: {
                title: overlay.querySelector('h3').textContent,
                location: overlay.querySelector('p').textContent
            }
        });

        // Evento para abrir el modal
        item.addEventListener('click', () => openModal(index));
    });

    // Controles del modal
    modalClose.addEventListener('click', closeModal);
    modalPrev.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updateModalImage();
    });
    modalNext.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updateModalImage();
    });

    // Cerrar modal si se hace clic fuera de la imagen
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Navegación con el teclado
    document.addEventListener('keydown', (e) => {
        if (modal.style.display === 'flex') {
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowLeft') modalPrev.click();
            if (e.key === 'ArrowRight') modalNext.click();
        }
    });
});
