// Animación al hacer scroll al botón de reserva
const button = document.querySelector('button');
button.addEventListener('mouseover', () => {
    button.style.transform = 'scale(1.1)';
    button.style.transition = 'transform 0.3s ease';
});

button.addEventListener('mouseout', () => {
    button.style.transform = 'scale(1)';
});

// Añadir animación de desplazamiento suave cuando se hace clic en los botones
const anchors = document.querySelectorAll('a[href^="#"]');
for (let anchor of anchors) {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
}
