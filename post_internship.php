<?php
include 'db_conn.php';
$employer_id = $_SESSION['employer_id'] ?? 1;
$message = "";

if (isset($_POST['submit'])) {

    $title       = $_POST['title'];
    $company     = $_POST['company'];
    $location    = $_POST['location'];
    $duration    = $_POST['duration'];
    $category    = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO internship 
        (title, company, location, duration, category, description, created_at, employer_id) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
    
    $stmt->bind_param("ssssssi", $title, $company, $location, $duration, $category, $description,  $employer_id);
    if ($stmt->execute()) {
        
        $stmt->close();
        header("Location: employer_internship.php");
    
        exit; 


    } else {
        $message = "Failed to Post Internship: " . $conn->error;
        $stmt->close();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Internship</title>
    <link rel="stylesheet" href="internship_listing.css">
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container {
            width: 45%; margin: 30px auto; background: white;
            padding: 25px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input, select, textarea {
            width: 100%; padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #bbb;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px; background: #28a745;
            border: none; color: white;
            cursor: pointer; border-radius: 5px;
        }
        button:hover { background: #218838; }
        .success {
            color: green; font-weight: bold;
            text-align: center; margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Post a New Internship</h2>

    <?php if ($message): ?>
        <p class="success"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="title" placeholder="Internship Title" required>

        <input type="text" name="company" placeholder="Company Name" required>

        <input type="text" name="location" placeholder="Location" required>

        <input type="text" name="duration" placeholder="Duration (e.g. 3 months)" required>

        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Frontend">Frontend</option>
            <option value="Backend">Backend</option>
            <option value="Design">Design</option>
            <option value="Full-stack">Full-stack</option>
        </select>

        <textarea name="description" rows="4" placeholder="Description" required></textarea>

         <button type="submit" name="submit">Post Internship</button>

    </form>

</div>

</body>
</html>
