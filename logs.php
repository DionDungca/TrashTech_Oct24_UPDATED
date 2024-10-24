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
    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
            font-family: \'Arial\', sans-serif;
            background: linear-gradient(135deg, #D187F5, #FFFFFF);
            height: 100vh;
            display: flex;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            padding: 20px;
            margin-top: 50px;
        }

        .logs-table-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .logs-table {
            width: 80%;
            max-width: 1200px;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logs-table th, .logs-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .logs-table thead {
            background-color: #f2f2f2;
        }

        .logs-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .logs-table {
                width: 100%;
            }
        }
    </style>
    <div class="main-content">
        <h1>Logs</h1>
        <div class="logs-table-container">
            <table class="logs-table" border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
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
        </div>
    </div>
';

include 'template.php';
?>
