<?php
// user_logs.php
include 'db_connection.php';
include 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch user logs for super admin
$sql = "SELECT users.username, user_logs.action, user_logs.timestamp 
        FROM user_logs 
        JOIN users ON user_logs.user_id = users.id 
        ORDER BY user_logs.timestamp DESC";
$result = $conn->query($sql);

$page_title = "User Logs Page";
$page_content = '
    <style>
        /* General page styling */
        body, html {
            margin: 0;
            padding: 0;
            font-family: \'Arial\', sans-serif;
            height: 100%;
        }

        /* Sidebar styling */
        .sidebar {
            width: 220px; /* Sidebar width */
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 20px;
            overflow-y: auto;
        }

        /* Header styling */
        header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 220px; /* Align header next to the sidebar */
            width: calc(100% - 220px); /* Fill the remaining width */
            z-index: 1000;
        }

        /* Content area styling */
        .content {
            margin-left: 0px; /* Adjust this to push content under the sidebar */
            padding: 20px;
            background: linear-gradient(135deg, #D187F5, #FFFFFF);
            min-height: calc(100vh - 0px); /* Ensure content takes the full viewport height minus header */
            margin-top: 40px; /* Push content below the fixed header */
            overflow-y: auto;
            box-sizing: border-box;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Header inside content */
        h1 {
            margin-top: 0;
            text-align: left; /* Ensure the heading aligns to the left */
        }
    </style>

    <div class="content">
        <h1>User Logs</h1>
        <table>
            <tr>
                <th>Username</th>
                <th>Action</th>
                <th>Date and Time (PHT)</th>
            </tr>';

while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['timestamp'], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Manila'));
    $formatted_date = $date->format('Y-m-d H:i:s');

    $page_content .= '
            <tr>
                <td>' . htmlspecialchars($row['username']) . '</td>
                <td>' . htmlspecialchars($row['action']) . '</td>
                <td>' . htmlspecialchars($formatted_date) . '</td>
            </tr>';
}

$page_content .= '
        </table>
    </div>
';

include 'template.php';
?>
