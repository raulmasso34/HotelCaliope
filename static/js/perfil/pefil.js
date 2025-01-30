
document.addEventListener('DOMContentLoaded', function() {
    const showMoreButton = document.getElementById('show-more');
    const showLessButton = document.getElementById('show-less');
    const moreReservations = document.getElementById('more-reservations');

    showMoreButton.addEventListener('click', function() {
        moreReservations.style.display = 'block';
        showMoreButton.style.display = 'none';
        showLessButton.style.display = 'inline-block';
    });

    showLessButton.addEventListener('click', function() {
        moreReservations.style.display = 'none';
        showMoreButton.style.display = 'inline-block';
        showLessButton.style.display = 'none';
    });
});

