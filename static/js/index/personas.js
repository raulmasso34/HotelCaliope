function togglePersonas() {
    const personasContent = document.getElementById("personas-content");
    personasContent.style.display = personasContent.style.display === "block" ? "none" : "block";
  }

  // Función para manejar el incremento
  function increment(id) {
    const input = document.getElementById(id);
    input.value = parseInt(input.value) + 1;
  }

  // Función para manejar el decremento
  function decrement(id) {
    const input = document.getElementById(id);
    if (parseInt(input.value) > parseInt(input.min)) {
      input.value = parseInt(input.value) - 1;
    }
  }

  // Función para mostrar u ocultar los contadores según la selección
  function mostrarCantidad() {
    const tipoPersona = document.getElementById("tipo_persona").value;
    const cantidadContainer = document.getElementById("cantidad-container");
    
    // Mostrar el contenedor de cantidad y actualizar el valor por defecto
    cantidadContainer.style.display = "block";
    
    // Se puede personalizar el texto o el valor por defecto basado en el tipo de persona
    const cantidadInput = document.getElementById("cantidad");
    cantidadInput.value = 1;
  }

  // Cierra el desplegable al hacer clic fuera del área de "personas-content"
  window.onclick = function(event) {
    const personasContent = document.getElementById("personas-content");
    const personasLabel = document.querySelector(".personas-label");
    
    if (event.target !== personasContent && event.target !== personasLabel && !personasContent.contains(event.target)) {
      personasContent.style.display = "none";
    }
  };