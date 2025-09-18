<?php
require_once __DIR__ . '/../server/db.php';

class Community {
  public static function getAllPosts() {
    global $conn;
    return $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
  }

  public static function createPost($userId, $title, $content) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $title, $content);
    return $stmt->execute();
  }
}
