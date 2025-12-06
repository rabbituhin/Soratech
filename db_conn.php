<?php
$host = "localhost";
$user = "mfrtuhin1";
$pass = "gAfLhR4F7b";
$db   = "mfrtuhin1";

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db   = "soratech";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



