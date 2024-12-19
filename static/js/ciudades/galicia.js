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


var map = L.map('map').setView([42.879, -8], 13.499);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 100,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


var marker = L.marker([42.879, -8]).addTo(map);
