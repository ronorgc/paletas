<?php
// Asegúrate de que no falte el inicio del archivo PHP con <?php
class Board {
    private $db;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->db = new Database();
    }

    // Método para obtener todos los tableros
    public function getAllBoards() {
        $query = "SELECT * FROM boards";
        $stmt = $this->db->query($query);

        // Devolver los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
