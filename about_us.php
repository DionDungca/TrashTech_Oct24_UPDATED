<?php
// about_us.php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$page_title = "About Us Page";
$page_content = '
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Adjust this value to match the header height */
            display: flex;
        }
        #content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
    </style>
    <div id="content">
        <h1>About Us</h1>
        <p>Information about TrashTech.</p>
        <h2>Mission</h2>
        <p>Our mission is to provide innovative waste management solutions that promote sustainability and environmental responsibility.</p>
        <h2>Vision</h2>
        <p>Our vision is to be a global leader in waste management, transforming waste into valuable resources and creating a cleaner, greener future for all.</p>
    </div>
';

include 'template.php';
?>


