<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('Location:auth.html');
    exit;
}

$username = $_SESSION['user_name']?? 'Guest';

$logout_text = ($username !== 'Guest') ? "Log out": "Log in";
$logout_href = ($username !== 'Guest') ? "logout.php" : "auth.html";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soratech | Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="student_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
</head>
<body>
    <header>
        
            <nav class="navbar">
                <div class="nav-container">
                    <!-- Logo -->
                        <a href="student_profile.php" class="logo"><img src="images/Soratech_logo.png" alt="Soratech_logo"></a>
                    

                    <!-- Desktop Navigation -->
                    <ul class="nav-links">
                        <li><a href="internship_listing.php">Explore Internships</a></li>
                        <li><a href="interview.php">Interview Scheduling</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li class="profile-group-dropdown">
                           <a href="javascript:void(0)" class="profile_toggle" id="profileToggle">
                                <i class="fa-solid fa-user-circle"></i>
                                <?php echo htmlspecialchars($username);?>
                                <i class="fa-solid fa-caret-down"></i>
                                <li><a href="logout.php" class="register-btn">Logout</a></li>
                            </a>
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
                        <li><a href="student_profile.php" class="mobile-link">Profile(<?php echo htmlspecialchars($username);?>)</a></li>
                        <li><a href="<?php echo $logout_href;?>" class="register-btn-mobile mobile-link"><?php echo $logout_text; ?></a></li>
                    </ul>
                </div>
            </nav>
            </header>
             <section class="hero">
                <div class="hero-content">
                    <h1>Find tech internship opportunities</h1>
                    <p>Connecting with verified and managing every stage of internship search journey.</p>

                    <div class="search-bar">
                        <!-- ARIA - Accessibility Rich Internet Applications
                        For People with disabilities -->
                        <input type="text" class="search-input" placeholder="Job or keyword" aria-label="Enter search Job or keyword">
                        <button class="btn" id="searchBtn">Search</button>
                    </div>
                    <button class="btn" id="browseBtn">Browse</button>
                </div>
            </section>
        </header>
        <!-- Featured Internships -->

        <section class="Internships">
            <h2 style="color: white;">Latest Internships</h2>

            <div class="listing">
                <div class="card">
                    <div class="image">
                    <img src="images/Meta.webp" alt="meta_logo" loading="lazy">
                    </div>
                    <h4 class="position">
                        Software Dev Intern
                    </h4>
                    <p class="company">Meta</p>
                    <button class="btn">Learn More</button>
                </div>
                <div class="card">
                    <div class="image">
                        <img src="images/Google.webp" alt="google_logo" loading="lazy">   
                    </div>
                    <h4 class="position">
                        IT Support Intern
                    </h4>
                    <p class="company">Google</p>
                    <button class="btn">Learn More</button>
                </div>
                <div class="card">
                    <div class="image">
                    <img src="images/Blackrock.webp" alt="blackrock_logo" loading="lazy">
                    </div>
                    <h4 class="position">
                        UI / UX Design Intern
                    </h4>
                    <p class="company">Blackrock</p>
                    <button class="btn">Learn More</button>
                </div>

            </div>
            
            
        </section>
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
                            <li><a href="internship_listing.php">Explore Internships</a></li>
                            <li><a href="about.html">About Us</a></li>
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
        </footer>
        <script src="home.js"></script>



            <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileToggle = document.getElementById('profileToggle');
            const profileMenu = document.getElementById('profileDropdownMenu');
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            // Desktop Dropdown Toggle
            if (profileToggle && profileMenu) {
                profileToggle.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    profileMenu.classList.toggle('visible');
                });

                // Close dropdown if click outside
                document.addEventListener('click', (event) => {
                    if (!profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
                        profileMenu.classList.remove('visible');
                    }
                });
            }
            
            // Mobile Menu Toggle
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
