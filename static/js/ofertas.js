document.addEventListener('DOMContentLoaded', function() {
    // Season tabs functionality
    const seasonTabs = document.querySelectorAll('.season-tab');
    const offerSections = document.querySelectorAll('.offers-section');

    seasonTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and sections
            seasonTabs.forEach(t => t.classList.remove('active'));
            offerSections.forEach(s => s.classList.remove('active'));

            // Add active class to clicked tab and corresponding section
            tab.classList.add('active');
            const season = tab.dataset.season;
            document.getElementById(`${season}-offers`).classList.add('active');
        });
    });

    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Add your newsletter subscription logic here
            alert('¡Gracias por suscribirte!');
            newsletterForm.reset();
        });
    }

    // Animate offer cards on scroll
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.offer-card').forEach(card => {
        observer.observe(card);
    });
});
