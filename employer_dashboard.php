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
    <meta name="description" content="Soratech Employer Dashboard - manage internships and applications">
    <title>Soratech | Employer Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>

      .tabs {
          display: flex;
          justify-content: center;
          margin: 20px 0;
      }
      .tab-btn {
          padding: 10px 20px;
          margin: 0 5px;
          cursor: pointer;
          background: #007bff;
          color: white;
          border: none;
          border-radius: 5px;
          font-size: 16px;
      }
      .tab-btn:hover {
          background: #0056b3;
      }
      .tab-content {
          display: none;
          padding: 20px;
          background: #f9f9f9;
          margin: 0 20px 20px 20px;
          border-radius: 8px;
          box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      .tab-content.active {
          display: block;
      }
  </style>  
</head>
<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar">
            <div class="nav-container">
                <!-- Logo -->
                <a href="employer_dashboard.php" class="logo">
                    <img src="images/Soratech_logo.png" alt="Soratech Logo">
                </a>

                <!-- Desktop Navigation -->
                <ul class="nav-links">
                    <li><a href="post_internship.php">Post Internship</a></li>
                    <li><a href="employer_internship.php">My Internships</a></li>
                    <a href="javascript:void(0)" class="profile_toggle" id="profileToggle">
                                <i class="fa-solid fa-user-circle"></i>
                                <?php echo htmlspecialchars($username);?>
                                <i class="fa-solid fa-caret-down"></i>
                                <li><a href="logout.php" class="logout-btn">Logout</a></li>
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
                   
                    <li><a href="post_internship.php" class="mobile-link">Post Internship</a></li>
                    <li><a href="employer_internship.php" class="mobile-link">Manage Internships</a></li>
             <a href="javascript:void(0)" class="profile_toggle" id="profileToggle">
                                <i class="fa-solid fa-user-circle"></i>
                                <?php echo htmlspecialchars($username);?>
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                    <li><a href="logout.php" class="mobile-link logout-btn">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Internship Sections -->
<div class="tabs">
    <button class="tab-btn" onclick="openTab('rules')">Rules</button>
    <button class="tab-btn" onclick="openTab('process')">Process</button>
    <button class="tab-btn" onclick="openTab('offers')">Offers</button>
    <button class="tab-btn" onclick="openTab('certificate')">Certificate</button>
</div>

<div id="rules" class="tab-content">
    <h2>Internship Rules</h2>
    <ul>
        <li>All interns must submit their reports on time.</li>
        <li>Maintain professional behavior during the internship.</li>
        <li>Attendance is mandatory for all scheduled sessions.</li>
    </ul>
</div>

<div id="process" class="tab-content">
    <h2>Internship Process</h2>
    <ol>
        <li>Apply for internship via the portal.</li>
        <li>Shortlisting and approval by employer.</li>
        <li>Start work and submit weekly progress.</li>
        <li>Final evaluation and feedback.</li>
    </ol>
</div>

<div id="offers" class="tab-content">
    <h2>Internship Offers</h2>
    <p>Selected interns may receive a stipend and pre-placement offers based on performance.</p>
</div>

<div id="certificate" class="tab-content">
    <h2>Internship Certificate</h2>
    <p>Interns completing the program successfully will receive a certificate of completion from Soratech.</p>
</div>

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        function openTab(tabId){
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
}

// Optionally, show first tab by default
openTab('rules');
    </script>
</body>
</html>
