// Datos mejorados para las habitaciones
const roomsData = [
    {
        title: "Suite Presidencial",
        price: 850,
        images: [
            'https://example.com/suite1-1.jpg',
            'https://example.com/suite1-2.jpg',
            'https://example.com/suite1-3.jpg'
        ],
        amenities: [
            {icon: "fa-wifi", text: "WiFi Premium"},
            {icon: "fa-hot-tub", text: "Jacuzzi Privado"},
            {icon: "fa-umbrella-beach", text: "Vista al Mar"}
        ],
        services: [
            "Conserjería 24h",
            "Acceso ilimitado al spa",
            "Traslado en limusina",
            "Desayuno a la carta"
        ],
        specs: {
            size: "120 m²",
            capacity: "3 personas",
            beds: "1 Cama King Size",
            view: "Vista Panorámica al Mar"
        },
        rating: 5
    },
    // Añadir más habitaciones...
];

// Generar tarjetas de habitaciones
function generateRoomCards() {
    const grid = document.querySelector('.rooms-grid');
    
    roomsData.forEach(room => {
        const amenitiesHTML = room.amenities.map(amenity => `
            <li><i class="fas ${amenity.icon}"></i> ${amenity.text}</li>
        `).join('');
        
        const cardHTML = `
            <article class="room-card">
                <div class="room-image">
                    <img src="${room.images[0]}" alt="${room.title}">
                </div>
                <div class="room-details">
                    <h2 class="room-title">${room.title}</h2>
                    <p class="room-price">$${room.price}/noche</p>
                    <ul class="amenities-list">${amenitiesHTML}</ul>
                    <button class="btn view-details">Ver Detalles</button>
                </div>
            </article>
        `;
        
        grid.insertAdjacentHTML('beforeend', cardHTML);
    });
}

// Lógica del Carrusel
let currentSlide = 0;
let slideInterval;

function initCarousel(images) {
    const carousel = document.querySelector('.carousel-inner');
    const dotsContainer = document.querySelector('.carousel-dots');

    // Limpiar contenido previo
    carousel.innerHTML = '';
    dotsContainer.innerHTML = '';

    // Generar imágenes y puntos
    images.forEach((img, index) => {
        carousel.insertAdjacentHTML('beforeend', `
            <img src="${img}" class="${index === 0 ? 'active' : ''}">
        `);

        dotsContainer.insertAdjacentHTML('beforeend', `
            <div class="dot ${index === 0 ? 'active' : ''}" data-index="${index}"></div>
        `);
    });

    // Asegurar que los botones de navegación existen antes de asignar eventos
    setTimeout(() => {
        document.querySelector('.carousel-prev').addEventListener('click', () => moveSlide(-1));
        document.querySelector('.carousel-next').addEventListener('click', () => moveSlide(1));
    }, 100); // Pequeño retraso para asegurar que los botones se han renderizado

    // Asignar eventos a los puntos de navegación
    document.querySelectorAll('.dot').forEach((dot) => {
        dot.addEventListener('click', () => {
            showSlide(parseInt(dot.dataset.index, 10));
        });
    });

    startSlideShow();
}


function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-inner img');
    const dots = document.querySelectorAll('.dot');
    
    currentSlide = (index + slides.length) % slides.length;
    
    slides.forEach((slide, i) => slide.classList.toggle('active', i === currentSlide));
    dots.forEach((dot, i) => dot.classList.toggle('active', i === currentSlide));
}

function moveSlide(direction) {
    const slides = document.querySelectorAll('.carousel-inner img');
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    showSlide(currentSlide);
    resetSlideShow();
}

function startSlideShow() {
    if(slideInterval) clearInterval(slideInterval);
    slideInterval = setInterval(() => moveSlide(1), 5000);
}

function resetSlideShow() {
    startSlideShow();
}

// Mostrar detalles en el modal de lujo
function showRoomDetails(roomIndex) {
    const room = roomsData[roomIndex];
    
    // Actualizar contenido principal
    document.querySelector('.luxury-title').textContent = room.title;
    document.querySelector('.luxury-price').textContent = `$${room.price}/noche`;
    document.querySelector('.luxury-rating').innerHTML = 
        Array(room.rating).fill('<i class="fas fa-star"></i>').join('');
    
    // Actualizar características
    const featuresList = document.querySelector('.luxury-features');
    featuresList.innerHTML = `
        <li><i class="fas fa-expand-arrows-alt"></i> ${room.specs.size}</li>
        <li><i class="fas fa-bed"></i> ${room.specs.beds}</li>
        <li><i class="fas fa-binoculars"></i> ${room.specs.view}</li>
        <li><i class="fas fa-users"></i> ${room.specs.capacity}</li>
    `;
    
    // Actualizar servicios
    const servicesList = document.querySelector('.luxury-services ul');
    servicesList.innerHTML = room.services.map(service => `
        <li><i class="fas fa-check-circle"></i> ${service}</li>
    `).join('');
    
    // Inicializar carrusel
    initCarousel(room.images);
    
    // Mostrar modal
    document.querySelector('.room-modal').style.display = 'block';
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    generateRoomCards();
    
    // Scroll suave
    document.querySelector('.scroll-down').addEventListener('click', () => {
        window.scrollTo({
            top: document.querySelector('.rooms-grid').offsetTop - 100,
            behavior: 'smooth'
        });
    });

    // Abrir modal
    document.querySelector('.rooms-grid').addEventListener('click', (e) => {
        if(e.target.closest('.view-details')) {
            const card = e.target.closest('.room-card');
            const roomIndex = [...document.querySelectorAll('.room-card')].indexOf(card);
            showRoomDetails(roomIndex);
        }
    });

    // Cerrar modal
    document.querySelector('.close-luxury').addEventListener('click', () => {
        document.querySelector('.room-modal').style.display = 'none';
        clearInterval(slideInterval);
    });

    window.addEventListener('click', (e) => {
        if(e.target.classList.contains('room-modal')) {
            document.querySelector('.room-modal').style.display = 'none';
            clearInterval(slideInterval);
        }
    });
});