// contacto.js
document.addEventListener('DOMContentLoaded', function() {
    // Función para la flecha de scroll
    function initScrollArrow() {
        const scrollArrow = document.querySelector('.scroll-down-arrow');
        const targetSection = document.getElementById('contact-section');

        if (!scrollArrow || !targetSection) return;

        // Comportamiento de scroll suave
        scrollArrow.addEventListener('click', function(e) {
            e.preventDefault();
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });

        // Ocultar flecha cuando se llega al final
        window.addEventListener('scroll', function() {
            const windowBottom = window.scrollY + window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            
            scrollArrow.style.opacity = (documentHeight - windowBottom > 100) ? '1' : '0';
        });

        // Añadir animación CSS
        const style = document.createElement('style');
        style.textContent = `
            .scroll-down-arrow {
                transition: all 0.3s ease;
                animation: bounce 2s infinite;
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-15px); }
                60% { transform: translateY(-7px); }
            }
            
            .scroll-down-arrow:hover {
                color: #c5a47e !important;
                transform: scale(1.2);
            }
        `;
        document.head.appendChild(style);
    }

    initScrollArrow();
});