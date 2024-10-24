<?php
// faq.php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM faqs";
$result = $conn->query($sql);

$page_title = "FAQ Page";

$page_content = '
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Adjust this value to match the header height */
            display: flex;
            background: linear-gradient(135deg, #D187F5, #FFFFFF); /* Add the background gradient */
            height: 100vh; /* Ensure the background covers the full viewport */
            box-sizing: border-box;
        }
        #content {
            margin-left: 145px;
            padding: 20px;
            width: calc(100% - 220px);
        }
        .faq-container {
            margin-top: 20px;
        }
        .faq-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .faq-question {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        .faq-answer {
            display: none;
            margin-top: 10px;
            color: #333;
        }
        .faq-toggle {
            cursor: pointer;
            font-weight: bold;
        }
    </style>

    <div id="content">
        <h1>FAQs</h1>
        <div class="faq-container">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $page_content .= '
            <div class="faq-item">
                <div class="faq-question">
                    <strong>' . htmlspecialchars($row['question']) . '</strong>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">' . htmlspecialchars($row['answer']) . '</div>
            </div>';
    }
} else {
    $page_content .= '<p>No FAQs found.</p>';
}

$page_content .= '
        </div>
    </div>';

include 'template.php';  // Includes the common header, footer, etc.
?>

<!-- Link the external JavaScript file for FAQ toggle functionality -->
<script src="faq.js"></script>
