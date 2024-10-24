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
    <h1>FAQs</h1>
    <div class="faq-container">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $page_content .= '
            <div class="faq-item">
                <div class="faq-question">
                    <strong>' . $row['question'] . '</strong>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">' . $row['answer'] . '</div>
            </div>';
    }
} else {
    $page_content .= '<p>No FAQs found.</p>';
}

$page_content .= '
    </div>';

include 'template.php';  // Includes the common header, footer, etc.
?>

<!-- Link the external CSS file -->
<link rel="stylesheet" href="faq.css">

<!-- Link the external JavaScript file -->
<script src="faq.js"></script>
