<?php
require_once __DIR__ . '/../server/db.php';

class Tip {
  public static function getAllTips() {
    global $conn;
    return $conn->query("SELECT * FROM tips ORDER BY id DESC");
  }

  public static function getTipsByCategory($category) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM tips WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    return $stmt->get_result();
  }
}
