<?php
require_once(__DIR__ . '/../config/db.php');

class Admin {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT id, name, email, created_at FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
