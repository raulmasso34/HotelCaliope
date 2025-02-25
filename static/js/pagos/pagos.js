function mostrarPopup(event) {
    event.preventDefault(); // Evita el envío inmediato del formulario

    // Crear la ventana emergente
    let popup = document.createElement("div");
    popup.id = "popup";

    // Crear contenido del popup
    let popupContent = document.createElement("div");
    popupContent.className = "popup-content";

    // Crear el título y el texto
    let title = document.createElement("h2");
    title.textContent = "Pago en proceso...";
    
    let text = document.createElement("p");
    text.innerHTML = `Redirigiendo en <span id="contador">5</span> segundos...`;

    // Añadir título y texto al contenido del popup
    popupContent.appendChild(title);
    popupContent.appendChild(text);
    
    // Añadir el contenido al popup
    popup.appendChild(popupContent);
    
    // Añadir el popup al body
    document.body.appendChild(popup);

    // Estilos para el popup
    Object.assign(popup.style, {
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        position: 'fixed',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: '300px',
        backgroundColor: '#fff',
        border: '2px solid #007bff',
        borderRadius: '10px',
        padding: '20px',
        boxShadow: '0 4px 15px rgba(0, 0, 0, 0.2)',
        zIndex: '1000'
    });

    // Estilos para el contenido del popup
    Object.assign(popupContent.style, {
        textAlign: 'center'
    });

    // Estilos para el título
    Object.assign(title.style, {
        color: '#007bff',
        marginBottom: '10px'
    });

    // Estilos para el texto
    Object.assign(text.style, {
        color: '#333',
        fontSize: '16px'
    });

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
