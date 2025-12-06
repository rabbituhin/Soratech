<?php
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Interview Scheduler</title>
        <link rel="stylesheet" href="interview.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        <header>
            <!-- Navbar -->
            <nav class="navbar">
                <div class="nav-container">
                    <!-- Logo -->
                        <a href="home.html" class="logo"><img src="images/Soratech_logo.png" alt="Soratech_logo"></a>
                    

                    <!-- Desktop Navigation -->
                    <ul class="nav-links">
                        <li><a href="internship_listing.php">Explore Internships</a></li>
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
                        <li><a href="contact.html" class="mobile-link">Contact</a></li>
                        <li><a href="auth.html" class="mobile-link">Login</a></li>
                        <li><a href="auth.html" class="register-btn-mobile mobile-link" onclick='register()'>Register</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <main class="main">
            
            <div class="container">
                <!-- Container Head -->
                <div class="header">
                    <h2>Interview Request</h2>
                    <p>Book your interview slot with no stress</p>
                </div>
                

                <!-- Calendar section -->

                <section class="main-content">
                    <div class="calendar-section">
                        <div class="section-title">
                            <h3 class="calendar-title">Select Date:</h3>
                        </div>

                        <div class="calendar">
                            <div class="calendar-header">
                                <button id="prevMonth">&lt;</button>
                                <h3 id="monthYear">*</h3>
                                <button id="nextMonth">&gt;</button>
                            </div>

                            <div class="weekdays">
                                <div class="weekday">Sun</div>
                                <div class="weekday">Mon</div>
                                <div class="weekday">Tue</div>
                                <div class="weekday">Wed</div>
                                <div class="weekday">Thu</div>
                                <div class="weekday">Fri</div>
                                <div class="weekday">Sat</div>
                            </div>

                            <div class="days" id="calendarDays"></div>
                        </div>

                        <!-- Time Slot section -->
                        <div class="section-title" style="margin-top: 30px;">
                            Available Time Slots
                        </div>
                        <div class="time-slots" id="timeSlots"></div>

                        <div class="bookings-list" id="bookingsList"></div>
                    </div>

                    
                    <!-- Booking form section -->
                    <div class="booking-section">
                        <div class="section-title">
                            <h3>Booking Details</h3>
                        </div>
                        <div class="booking-form">
                            <div class="input-group">
                                <label for="candidateName">Your Name *</label>
                                <input type="text" id="candidateName" placeholder="Enter your full name" autocomplete="name" maxlength="100" required>
                            </div>

                            <div class="input-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" placeholder="your.email@example.com" autocomplete="email" maxlength="254" required>
                            </div>

                            <div class="input-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" placeholder="+1 (555) 123-4567" autocomplete="tel">
                            </div>
                            <div class="input-group">
                                <label for="position">Position Applied For *</label>
                                <input type="text" id="position" placeholder="Enter your position" required>
                            </div>

                            <div class="input-group">
                                <label for="notes">Interview Summary</label>
                                <textarea id="notes" placeholder="Any special requirements or notes..."></textarea>
                            </div>

                            <div class="input-group">
                                <label>Set Reminders</label>
                                <div class="reminder-option">
                                    <input type="checkbox" id="reminder24" value="24" checked>
                                    <label for="reminder24">24 hours before</label>
                                </div>
                                <div class="reminder-option">
                                    <input type="checkbox" id="reminder1" value="1" checked>
                                    <label for="reminder1">1 hour before</label>
                                </div>
                                <div class="reminder-option">
                                    <input type="checkbox" id="reminder15" value="15">
                                    <label for="reminder15">15 minutes before</label>
                                </div>
                            </div>

                            <button class="btn" id="bookBtn" disabled>Book Interview</button>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Confrimation Pop-up -->
            <div class="modal" id="confirmModal">
                <div class="modal-content">
                    <div class="modal-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <h2>Confirm Your Interview</h2>
                    <p><strong>Date: </strong><span id="confirmDate"></span></p>
                    <p><strong>Time: </strong><span id="confirmTime"></span></p>
                    <p><strong>Position: </strong><span id="confirmPosition"></span></p>
                    <p><strong>Reminders: </strong><span id="confirmReminders"></span></p>
                    <div class="modal-buttons">
                        <button class="btn-secondary" id="cancelConfirm">Cancel</button>
                        <button class="btn-primary" id="confirmBook">Confirm Booking</button>
                    </div>
                </div>
            </div>

            <!-- Success nofication Pop-up -->
            <div class="modal" id="successModal">
                <div class="modal-content">
                    <div class="modal-icon"><i class="fa-regular fa-calendar-days"></i></div>
                    <h2>Interview Scheduled!</h2>
                    <p>Your interview has been successfully booked.</p>
                    <p>A confirmation email has been sent to <strong id="successEmail"></strong></p>
                    <p>You will receive reminders as per your selected preferences.</p>
                    <div class="modal-buttons">
                        <button class="btn-primary" id="closeSuccess">Got it!</button>
                    </div>
                </div>
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
                        <a href="#terms">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="home.js"></script>
        
        <script src="interview.js"></script>
    </body>
</html>