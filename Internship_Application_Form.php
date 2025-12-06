<?php
include 'db_conn.php';
session_start();
if (!isset($_SESSION['user_name'])){
    header('Location:auth.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Application</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="internship_application.css">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo -->
                <a href="home.html" class="logo"><img src="images/Soratech_logo.png" alt="Soratech_logo"></a>
            

            <!-- Desktop Navigation -->
            <ul class="nav-links">
                <li><a href="internship_listing.php">Explore Internships</a></li>
                <li><a href="interview.php">Interview Scheduling</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="auth.html">Login</a></li>
                <li><a href="auth.html" class="register-btn" id="nav-register-button">Register</a></li>
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
                <li><a href="internship_listing.php" class="mobile-link">Explore Internships</a></li>
                <li><a href="interview.php" class="mobile-link">Interview</a></li>
                <li><a href="contact.html" class="mobile-link">Contact</a></li>
                <li><a href="auth.html" class="mobile-link">Login</a></li>
                <li><a href="auth.html" class="register-btn-mobile mobile-link" onclick='register()'>Register</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <div class="box">
            <h2>Internship Application</h2>

            <form id="applyForm">

                <label>Full Name *</label>
                <input type="text" name="fullname" required>

                <label>Email *</label>
                <input type="email" name="email" required>

                <label>Resume (PDF)</label>
                <input type="file" name="resume" accept="application/pdf" required>

                <label>Cover Letter *</label>
                <textarea name="cover" id="cover" maxlength="500" required></textarea>
                <div id="count">0 / 500</div>

                <label>Status</label>
                <select name="status">
                    <option value="submitted">Submitted</option>
                    <option value="reviewing">Under Review</option>
                    <option value="scheduled">Interview Scheduled</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>

                <button type="submit" class="application_submit_button">Submit</button>

                <div id="note"></div>
            </form>

        </div>
    </main>
    
    <!--Footer section - Bottom of the website-->
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
                        <li><a href="internship_listing.html">Explore Internships</a></li>
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
    <script src="home.js"></script>
    <script src="internship_application.js"></script>

</body>
</html>