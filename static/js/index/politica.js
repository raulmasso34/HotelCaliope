document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("privacy-banner");
    const acceptButton = document.getElementById("accept-btn");
  
    acceptButton.addEventListener("click", function () {
      banner.style.display = "none"; // Oculta el banner cuando se hace clic en "Aceptar"
    });
  
    // Si deseas que el banner siempre se muestre en cada carga, no guardes un estado. 
    // Si quieres guardar la preferencia, puedes usar cookies o localStorage:
    // localStorage.setItem("privacyAccepted", "true");
  });
  