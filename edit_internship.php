<?php
session_start();
include 'db_conn.php'; 
// var_dump($conn);


// 1. Authentication: Ensure the user is logged in as an employer
if (!isset($_SESSION['employer_id'])) { 
    header("Location: auth.html"); 
    exit;
}
$current_employer_id = $_SESSION['employer_id'];

//Ensure the internship ID is provided in the URL
if (!isset($_GET['id']) && !isset($_GET['employer_id'])) {
    die("Error: No internship ID / Employer Id provided.");
}

// Sanitize the ID from the URL
$internship_id = intval($_GET['id']);

$employer_id = intval($_GET['employer_id']);
// echo"iid".$internship_id;
// echo"eid".$employer_id;


$success_message = "";
$error_message = "";

$stmt = $conn->prepare("SELECT * FROM internship WHERE id = ? AND employer_id = ?");
$stmt->bind_param("ii", $internship_id, $employer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
//    echo "Num rows: " . $result->num_rows;
    die("Internship not found or access denied.");
}

$internship = $result->fetch_assoc();
$stmt->close(); // Close the SELECT statement

// --- HANDLE FORM SUBMISSION (UPDATE OPERATION) ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Collect and sanitize data from the POST request
    $title       = trim($_POST['title']);
    $company     = trim($_POST['company']);
    $location    = trim($_POST['location']);
    $duration    = trim($_POST['duration']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description']);
    
    // The UPDATE statement: Securely updates only the owner's record
    $update = $conn->prepare("UPDATE internship SET title=?, company=?, location=?, duration=?, category=?, description=? WHERE id=? AND employer_id=?");
    
    // Bind parameters: 6 strings (s) for form data, 2 integers (i) for IDs
    $update->bind_param("ssssssii", 
        $title, 
        $company, 
        $location, 
        $duration, 
        $category, 
        $description, 
        $internship_id, 
        $employer_id    
    );

    if ($update->execute()) {
        header("Location: employer_internship.php");
        
        // Refetch the updated data to pre-fill the form with the new values immediately
        $stmt_refetch = $conn->prepare("SELECT * FROM internship WHERE id = ?");
        $stmt_refetch->bind_param("i", $internship_id);
        $stmt_refetch->execute();
        $internship = $stmt_refetch->get_result()->fetch_assoc();
        $stmt_refetch->close();
        
    } else {
        $error_message = "Error updating internship: " . $update->error; 
    }
    
    $update->close();
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Internship | <?= htmlspecialchars($internship['title']) ?></title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .container {
            width: 50%; margin: 30px auto; background: white;
            padding: 25px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input, select, textarea { width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid #bbb; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; border: none; color: white; cursor: pointer; border-radius: 5px; }
        button:hover { background: #0056b3; }
        .success { color: green; background-color: #d4edda; padding: 10px; border-radius: 5px; text-align: center; }
        .error { color: red; background-color: #f8d7da; padding: 10px; border-radius: 5px; text-align: center; }
    </style>
</head>

<body>

<div class="container">
    <h2>Edit Internship Listing: <?= htmlspecialchars($internship['title']) ?></h2>

    <?php if ($success_message): ?>
        <p class="success">✅ <?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p class="error">❌ <?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form method="POST">
        
        <input type="text" name="title" placeholder="Internship Title" 
                value="<?= htmlspecialchars($internship['title']) ?>" required>

        <input type="text" name="company" placeholder="Company Name" 
                value="<?= htmlspecialchars($internship['company']) ?>" required>

        <input type="text" name="location" placeholder="Location" 
                value="<?= htmlspecialchars($internship['location']) ?>" required>

        <input type="text" name="duration" placeholder="Duration (e.g. 3 months)" 
                value="<?= htmlspecialchars($internship['duration']) ?>" required>

        <select name="category" required>
            <option value="">Select Category</option>
            <?php 
            $categories = ['Frontend', 'Backend', 'Design', 'Full-stack'];
            foreach ($categories as $cat) {
                // Pre-select the current category
                $selected = ($internship['category'] == $cat) ? 'selected' : '';
                echo "<option value='{$cat}' {$selected}>{$cat}</option>";
            }
            ?>
        </select>

        <textarea name="description" rows="4" placeholder="Description" required><?= htmlspecialchars($internship['description']) ?></textarea>

        <button type="submit">Update Internship</button>

    </form>

</div>

</body>
</html>