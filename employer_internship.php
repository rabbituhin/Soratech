<?php
session_start();
include 'db_conn.php';

$employer_id = $_SESSION['id'] ?? 1;

$stmt = $conn->prepare("SELECT * FROM internship WHERE employer_id = ?");
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>My Internships</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{font-family:Arial;background:#eef2f3;padding:20px}
.card{background:white;padding:15px;margin-bottom:15px;border-radius:10px;box-shadow:0 3px 10px rgba(0,0,0,0.1)}
.btn{padding:8px 12px;text-decoration:none;border-radius:5px;color:white;margin-right:5px}
.edit{background:#007bff}
.delete{background:#dc3545}
</style>
</head>
<body>

<h2>My Internship Posts</h2>
</div>
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>

        <div class="card">
            <h3><?= $row['title'] ?></h3>
            <p><strong>Company:</strong> <?= $row['company'] ?></p>
            <p><strong>Location:</strong> <?= $row['location'] ?></p>
            <p><strong>Duration:</strong> <?= $row['duration'] ?></p>
            <p><strong>Posted Time</strong> <?= $row['created_at'] ?></p>

           <a href="edit_internship.php?id=<?= $row['id'] ?>&employer_id=<?=$row['employer_id']?>" class="btn edit">Edit</a>
            <a href="delete_internship.php?id=<?= $row['id'] ?>&employer_id=<?=$row['employer_id']?>" onclick="return confirm('Delete this internship?')" class="btn delete">Delete</a>
        </div>

    <?php endwhile; ?>
<?php else: ?>
    <p>You have not posted any internships yet.</p>
<?php endif; ?>

</body>
</html>
