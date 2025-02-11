function calcularPrecioTotal() {
    const checkinInput = document.getElementById("checkin").value;
    const checkoutInput = document.getElementById("checkout").value;
    const precioPorNoche = parseFloat(document.getElementById("precioPorNoche").textContent);
    const precioTotalSpan = document.getElementById("precioTotal");

    if (!checkinInput || !checkoutInput) {
        precioTotalSpan.textContent = "Selecciona fechas";
        return;
    }

    const checkinDate = new Date(checkinInput);
    const checkoutDate = new Date(checkoutInput);
    const diffTime = checkoutDate - checkinDate;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays > 0) {
        const precioTotal = diffDays * precioPorNoche;
        precioTotalSpan.textContent = precioTotal.toFixed(2);
    } else {
        precioTotalSpan.textContent = "Fechas inválidas";
    }
}

document.addEventListener("DOMContentLoaded", calcularPrecioTotal);
document.getElementById("checkin").addEventListener("change", calcularPrecioTotal);
document.getElementById("checkout").addEventListener("change", calcularPrecioTotal);