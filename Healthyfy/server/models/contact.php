<?php
require_once(__DIR__ . '/../config/db.php');

class Contact {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function submit($name, $email, $subject, $message) {
        $stmt = $this->conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $subject, $message]);
    }
}
?>
