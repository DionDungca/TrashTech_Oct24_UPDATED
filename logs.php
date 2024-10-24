<?php
// logs.php
include 'db_connection.php';
include 'header.php';

// Check if the session is already started, if not, start it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch logs for regular users
$sql = "SELECT Material_category, Date, weight 
        FROM logs 
        ORDER BY Date DESC";
$result = $conn->query($sql);

$page_title = "Logs Page";
$page_content = '
    <h1>Logs</h1>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Material Category</th>
                <th>Date</th>
                <th>Weight (kg)</th>
            </tr>
        </thead>
        <tbody>';

while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['Date'], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Manila'));
    $formatted_date = $date->format('Y-m-d H:i:s');

    $page_content .= '
            <tr>
                <td>' . $row['Material_category'] . '</td>
                <td>' . $formatted_date . '</td>
                <td>' . $row['weight'] . '</td>
            </tr>';
}

$page_content .= '
        </tbody>
    </table>
';

include 'template.php';
?>
