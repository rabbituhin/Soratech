<?php
session_start();
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['first_name'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === "Employer") {
                $_SESSION['employer_id'] = $row['id']; 
            }

            if ($row['role'] === "Student") {
                header("Location: student_profile.php");
            } elseif ($row['role'] === "Employer") {
                header("Location: employer_dashboard.php");
            } elseif ($row['role'] === "Admin") {
                header("Location: admin_dashboard.php");
            }
            exit; 
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='auth.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='auth.html.';</script>";
    }

    $stmt->close();
    $conn->close();
}

