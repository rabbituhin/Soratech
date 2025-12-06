<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $password   = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role       = $_POST['role'];

    if ($password !== $confirm_password) {
        header("Location: auth.html?error=password_mismatch");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user 
            (first_name, last_name, email, phone, password, role, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", 
        $first_name,
        $last_name,
        $email,
        $phone,
        $hashed_password,
        $role
    );

    if ($stmt->execute()) {
        header("Location: auth.html?registered=1");
        $stmt->close();
        $conn->close();
        exit();
    } else {
        header("Location: auth.html?error=register_failed");
        $stmt->close();
        $conn->close();
        exit();
    }
}
?>

