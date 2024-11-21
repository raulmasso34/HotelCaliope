<?php
require_once('Database.php');

$database = new Database();
$connection = $database->getConnection();

if ($connection) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión a la base de datos.";
}

$database->closeConnection(); // Cierra la conexión después de la prueba
?>
