<?php
include 'db_conn.php';


// Get search & filter input
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';

$sql = "SELECT * FROM internship WHERE 1=1";
if ($search) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (title LIKE '%$search%' OR company LIKE '%$search%')";
}
if ($filter !== 'all') {
    $filter = $conn->real_escape_string($filter);
    $sql .= " AND category='$filter'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internships</title>
    <link rel="stylesheet" href="internship_listing.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar here (same as before) -->
     <nav class="navbar">
        <div class="nav-container">
            <!-- Logo -->
                <a href="home.html" class="logo"><img src="images/Soratech_logo.png" alt="Soratech_logo"></a>
            

            <!-- Desktop Navigation -->
            <ul class="nav-links">
                <li><a href="interview.php">Interview Scheduling</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <ul class="mobile-menu-list">
                <li><a href="internship_listing.php" class="mobile-link"> Internships</a></li>
                <li><a href="interview.php" class="mobile-link">Interview Scheduling</a></li>
                <li><a href="contact.html" class="mobile-link">Contact</a></li>
            </ul>
        </div>
    </nav>

    <h1>Internship Opportunities</h1>

    <form method="GET" action="internship_listing.php" class="search-filter">
        <input type="text" name="search" placeholder="Title or company" value="<?= htmlspecialchars($search) ?>">
        <select name="filter">
            <option value="all" <?= $filter=='all'?'selected':'' ?>>All</option>
            <option value="Frontend" <?= $filter=='Frontend'?'selected':'' ?>>Frontend</option>
            <option value="Backend" <?= $filter=='Backend'?'selected':'' ?>>Backend</option>
            <option value="Design" <?= $filter=='Design'?'selected':'' ?>>Design</option>
            <option value="Full-stack" <?= $filter=='Full-stack'?'selected':'' ?>>Full-stack</option>
        </select>
        <button type="submit" class="btn-Search">Search</button>
    </form>

    <div class="internship-card">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card" category="<?= $row['category'] ?>">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><strong>Company:</strong> <?= htmlspecialchars($row['company']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($row['duration']) ?></p>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <a href="Internship_Application_Form.php?id=<?= $row['id'] ?>" class="btn1">Apply</a>
                    <form method="POST" action="save_internship.php" style="display:inline;">
                        <input type="hidden" name="internship_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                        <button type="submit" class="btn2">Save</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No internships found.</p>
        <?php endif; ?>
    </div>

    <!-- Footer here (same as before) -->
     <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- About Section -->
                <div class="footer-section">
                    <h3>SORATECH</h3>
                    <p>Connecting students with verified employers and managing every stage of your internship search journey.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.twitter.com" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.instagram.com" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Nav Links -->
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="home.html">Home</a></li>
                        <li><a href="internship_listing.php">Explore Internships</a></li>
                        <li><a href="interview.html">Interview Scheduling</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li><a href="auth.html">Login</a></li>
                        <li><a href="auth.html">Register</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; 2025 SORATECH. All rights reserved.</p>
                <div class="footer-bottom-links">
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
