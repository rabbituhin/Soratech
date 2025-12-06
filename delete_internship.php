<?php
session_start();
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    
    $internship_id = intval($_GET['id']);
    $employer_id = intval($_GET['employer_id']);

    $stmt = $conn->prepare("DELETE FROM internship WHERE id = ? AND employer_id = ?");
    $stmt->bind_param("ii", $internship_id, $employer_id);

  
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Success
            header("Location: employer_internship.php?message=Listing deleted successfully.");
            exit;
        } else {
            // Listing not found or the employer didn't own it
            header("Location: employer_internship.php?error=Listing not found or access denied.");
            exit;
        }
    } else {
        // SQL execution error
        header("Location: employer_internship.php?error=Database error: " . $conn->error);
        exit;
    }

} else {
    // Redirect if accessed directly without POST data
    header("Location: employer_dashboard.php");
    exit;
}
?>