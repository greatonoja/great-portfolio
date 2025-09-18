<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    die("Email and password are required.");
  }

  $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      // Login success
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['full_name'];
      $_SESSION['role'] = $user['role'];

      // Redirect based on role
      if ($user['role'] === 'admin') {
        header("Location: ../html/admin.html");
      } else {
        header("Location: ../html/dashboard.html");
      }
      exit;
    } else {
      echo "Incorrect password.";
    }
  } else {
    echo "No user found with that email.";
  }

  $stmt->close();
  $conn->close();
}
?>
