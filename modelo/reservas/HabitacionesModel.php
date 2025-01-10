<?php
class HabitacionesModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function filtrarHabitaciones($filtros) {
        $query = "SELECT * FROM habitaciones WHERE disponibilidad = 1 AND fecha_inicio_disponible <= :checkIn AND fecha_fin_disponible >= :checkOut";
        $params = [
            ':checkIn' => $filtros['checkIn'],
            ':checkOut' => $filtros['checkOut']
        ];

        if (!empty($filtros['tipo'])) {
            $query .= " AND tipo = :tipo";
            $params[':tipo'] = $filtros['tipo'];
        }

        if (!empty($filtros['precioMax'])) {
            $query .= " AND precio <= :precioMax";
            $params[':precioMax'] = $filtros['precioMax'];
        }

        if (!empty($filtros['servicios'])) {
            foreach ($filtros['servicios'] as $servicio) {
                $query .= " AND JSON_CONTAINS(servicios, :servicio_$servicio)";
                $params[":servicio_$servicio"] = json_encode($servicio);
            }
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
