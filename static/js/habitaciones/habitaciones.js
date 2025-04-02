document.addEventListener("DOMContentLoaded", function() {
    // Obtén todos los botones de filtro
    const filterButtons = document.querySelectorAll(".filter-btn");
    const gallerySections = document.querySelectorAll(".gallery-section");

    filterButtons.forEach(button => {
        button.addEventListener("click", function() {
            const filter = this.getAttribute("data-filter");

            // Mostrar u ocultar las secciones de la galería basadas en el filtro
            gallerySections.forEach(section => {
                if (filter === "all") {
                    section.style.display = "block";
                } else {
                    const continent = section.getAttribute("data-continent").toLowerCase();
                    if (continent === filter) {
                        section.style.display = "block";
                    } else {
                        section.style.display = "none";
                    }
                }
            });

            // Cambiar la clase activa del filtro
            filterButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
