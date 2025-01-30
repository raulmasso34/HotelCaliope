document.getElementById('checkin').addEventListener('change', function() {
    const checkinDate = this.value;
    document.getElementById('checkout').setAttribute('min', checkinDate);
});
