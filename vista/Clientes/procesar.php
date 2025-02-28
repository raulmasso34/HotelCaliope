<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['captcha'])) {
        die("❌ Error: Debes marcar el CAPTCHA.");
    }

    // Aquí iría tu código de validación del usuario y la contraseña
    echo "✔ CAPTCHA correcto. Iniciando sesión...";
}
?>