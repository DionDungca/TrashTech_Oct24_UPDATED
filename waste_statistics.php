<?php
// waste_statistics.php
include 'db_connection.php';
include 'header.php'; // Include the header file for the page

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    // Handle the case where user_id is not set
    echo "User ID is not set in the session.";
    exit();
}

// Get company name from session
$company_name = $_SESSION['company_name'];

// Example query to fetch waste statistics for the user's company
$sql = "SELECT * FROM waste_statistics WHERE company_name='$company_name'";
$result = $conn->query($sql);

// Check if there are results for the query
if ($result === false) {
    echo "Error fetching waste statistics: " . $conn->error;
    exit();
}

$page_title = "Waste Statistics Page";
$page_content = '
    <style>
        /* General page and body styling */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
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
            z-index: 1000; /* Ensure sidebar is on top of the content */
        }

        /* Header styling */
        header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 220px; /* Move header to the right of sidebar */
            width: calc(100% - 220px); /* Adjust width to match sidebar */
            z-index: 999; /* Ensure header is above the content */
            box-sizing: border-box;
        }

        /* Content section (where the charts are displayed) */
        #content {
            margin-left: 220px; /*(Dion) pinalitan ko tong 220*/
            margin-top: 60px; /* (Dion) from 10 ginawa kong 60, para sa space sa ilalim */
            padding: 20px;
            background: linear-gradient(135deg, #D187F5, #FFFFFF);
            height: calc(100vh - 0px); /*(Dion) from 80px to 0px para sagad sa ilalim yung boarder*/
            overflow-y: auto; /* Ensure content scrolls if needed */
            box-sizing: border-box;
        }

        /* Chart containers styling */
        .chart-vertical-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-top: 20px;
        }

        .chart-container {
            position: relative;
            height: 400px; /* Increased height for better chart visibility */
            width: 100%;
        }

        /* Ensures charts scale correctly */
        .chart-container canvas {
            max-height: 100%;
            max-width: 100%;
        }

        /* Heading styling for waste statistics */
        h1 {
            margin-top: 0;
            font-size: 2rem; /* Increased font size for better visibility */
            text-align: left;
            padding-left: 10px; /* Adds a little spacing from the left */
        }
    </style>
    
    <h1>Waste Statistics</h1>
    <div class="chart-vertical-container">
        <div class="chart-container">
            <canvas id="paperChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="plasticChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="metalChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="glassChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartConfig = (ctx, label, data) => ({
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: "#D187F5",
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#333333",
                            font: {
                                family: "Arial, Helvetica, sans-serif",
                                size: 12
                            }
                        },
                        grid: {
                            color: "rgba(0, 0, 0, 0.1)"
                        }
                    },
                    x: {
                        ticks: {
                            color: "#333333",
                            font: {
                                family: "Arial, Helvetica, sans-serif",
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        padding: 10,
                    }
                }
            }
        });

        const paperCtx = document.getElementById("paperChart").getContext("2d");
        const plasticCtx = document.getElementById("plasticChart").getContext("2d");
        const metalCtx = document.getElementById("metalChart").getContext("2d");
        const glassCtx = document.getElementById("glassChart").getContext("2d");

        new Chart(paperCtx, chartConfig(paperCtx, "Paper", [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]));
        new Chart(plasticCtx, chartConfig(plasticCtx, "Plastic", [15, 25, 35, 45, 55, 65, 75, 85, 95, 105, 115, 125]));
        new Chart(metalCtx, chartConfig(metalCtx, "Metal", [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130]));
        new Chart(glassCtx, chartConfig(glassCtx, "Glass", [25, 35, 45, 55, 65, 75, 85, 95, 105, 115, 125, 135]));
    </script>
';

include 'template.php';
?>
