function mostrarPopup(event) {
    event.preventDefault(); // Evita el envío inmediato del formulario
    
    // Crear la ventana emergente
    let popup = document.createElement("div");
    popup.id = "popup";
    popup.innerHTML = `
        <div class="popup-content">
            <h2>Pago en proceso...</h2>
            <p>Redirigiendo en <span id="contador">5</span> segundos...</p>
        </div>
    `;
    document.body.appendChild(popup);
    
    // Contador de redirección
    let tiempo = 5;
    let contadorElemento = document.getElementById("contador");
    let intervalo = setInterval(() => {
        tiempo--;
        contadorElemento.textContent = tiempo;
        if (tiempo === 0) {
            clearInterval(intervalo);
            document.forms["pagoForm"].submit(); // Envía el formulario automáticamente
        }
    }, 1000);
}