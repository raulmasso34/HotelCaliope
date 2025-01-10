// hotelModel.php
<?php
require_once __DIR__ . '/../../config/Database.php';
class HotelModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener los hoteles disponibles por país
    public function obtenerHotelesPorPais($paisId) {
        $sql = "SELECT * FROM Hotel WHERE Id_Pais = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paisId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

