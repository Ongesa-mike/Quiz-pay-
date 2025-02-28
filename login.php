<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php"); // Redirect to dashboard
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>
