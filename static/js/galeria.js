document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sections = document.querySelectorAll('.gallery-section');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remover clase active de todos los botones
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Añadir clase active al botón clickeado
            button.classList.add('active');

            const filter = button.getAttribute('data-filter');

            // Mostrar/ocultar secciones según el filtro
            sections.forEach(section => {
                if (filter === 'all') {
                    section.classList.remove('hidden');
                } else if (section.classList.contains(filter)) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        });
    });
});
