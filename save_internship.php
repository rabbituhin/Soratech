<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['id'])){
    header('Location:auth.html');
    exit;
}
$student_id = $_SESSION['id'];
$saved_internships = []; 

$sql = "SELECT i.*, si.saved_at
        FROM internship i
        JOIN saved_internships si ON i.id = si.internship_id
        WHERE si.user_id = ? 
        ORDER BY si.saved_at DESC";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $student_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    
    // Fetch all results into an array
    while ($row = $result->fetch_assoc()) {
        $saved_internships[] = $row;
    }
} else {
    // Handle database error
    error_log("Dashboard query failed: " . $stmt->error);
}

$stmt->close();
$conn->close();

echo "successful";
?>
