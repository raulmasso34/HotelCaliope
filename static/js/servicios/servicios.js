document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const checkboxes = document.querySelectorAll('.option-checkbox');
    const continueButton = document.querySelector('.btn-continue');
    const confirmationModal = document.getElementById('confirmationModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    
    // Textos para los diferentes estados
    const defaultText = 'Continuar sin servicios ni actividades';
    const withSelectionText = 'Continuar con el pago';
    
    // Función para verificar selecciones
    function checkSelectedOptions() {
        const isAnySelected = Array.from(checkboxes).some(checkbox => checkbox.checked);
        continueButton.innerHTML = `<i class=""></i> ${isAnySelected ? withSelectionText : defaultText}`;
    }
    
    // Función para mostrar el modal
    function showModal() {
        confirmationModal.classList.add('modal-show');
    }
    
    // Función para ocultar el modal
    function hideModal() {
        confirmationModal.classList.remove('modal-show');
    }
    
    // Event listeners para checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', checkSelectedOptions);
    });
    
    // Event listener para el botón continuar
    continueButton.addEventListener('click', function(e) {
        const isAnySelected = Array.from(checkboxes).some(checkbox => checkbox.checked);
        
        if (!isAnySelected) {
            e.preventDefault();
            showModal();
        }
    });
    
    // Event listeners para los botones del modal
    cancelBtn.addEventListener('click', hideModal);
    confirmBtn.addEventListener('click', function() {
        hideModal();
        document.querySelector('form').submit(); // Envía el formulario
    });
    
    // Cerrar modal al hacer clic fuera del contenido
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            hideModal();
        }
    });
    
    // Verificar estado inicial
    checkSelectedOptions();
});