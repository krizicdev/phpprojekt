<?php
// Created/Modified files during execution:
// config.php

$servername = "localhost";
$username   = "root";   // Change if needed
$password   = "root";       // Change if needed
$dbname     = "nekretnine_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a session
if (!session_id()) {
    session_start();
}
?>