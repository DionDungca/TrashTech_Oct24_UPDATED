<?php 
// Start the session to retrieve the logged-in user information
include 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['company_name'])) {
    die("User not logged in");
}

// Get the logged-in user's company name from the session
$company_name = $_SESSION['company_name'];

// Database connection

// Fetch the latest bin level and weight data from respective tables
$bin_data = array();

// Fetch Plastic data
$plastic_level_query = "SELECT level, timestamp FROM plastic_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_weight_query = "SELECT weight, timestamp FROM plastic_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_level_result = $conn->query($plastic_level_query);
$plastic_weight_result = $conn->query($plastic_weight_query);

if ($plastic_level_result->num_rows > 0 && $plastic_weight_result->num_rows > 0) {
    $plastic_level = $plastic_level_result->fetch_assoc();
    $plastic_weight = $plastic_weight_result->fetch_assoc();
    $bin_data['plastic'] = array_merge($plastic_level, $plastic_weight);
}

// Fetch Glass data
$glass_level_query = "SELECT level, timestamp FROM glass_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$glass_weight_query = "SELECT weight, timestamp FROM glass_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$glass_level_result = $conn->query($glass_level_query);
$glass_weight_result = $conn->query($glass_weight_query);

if ($glass_level_result->num_rows > 0 && $glass_weight_result->num_rows > 0) {
    $glass_level = $glass_level_result->fetch_assoc();
    $glass_weight = $glass_weight_result->fetch_assoc();
    $bin_data['glass'] = array_merge($glass_level, $glass_weight);
}

// Fetch Metal data
$metal_level_query = "SELECT level, timestamp FROM metal_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_weight_query = "SELECT weight, timestamp FROM metal_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_level_result = $conn->query($metal_level_query);
$metal_weight_result = $conn->query($metal_weight_query);

if ($metal_level_result->num_rows > 0 && $metal_weight_result->num_rows > 0) {
    $metal_level = $metal_level_result->fetch_assoc();
    $metal_weight = $metal_weight_result->fetch_assoc();
    $bin_data['metal'] = array_merge($metal_level, $metal_weight);
}

// Fetch Paper data
$paper_level_query = "SELECT level, timestamp FROM paper_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_weight_query = "SELECT weight, timestamp FROM paper_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_level_result = $conn->query($paper_level_query);
$paper_weight_result = $conn->query($paper_weight_query);

if ($paper_level_result->num_rows > 0 && $paper_weight_result->num_rows > 0) {
    $paper_level = $paper_level_result->fetch_assoc();
    $paper_weight = $paper_weight_result->fetch_assoc();
    $bin_data['paper'] = array_merge($paper_level, $paper_weight);
}

// Close connection
$conn->close();

// Return bin data as JSON for AJAX requests
//echo json_encode($bin_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - <?php echo $_SESSION['company_name']; ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Bin Level and Weight Data for <?php echo $_SESSION['company_name']; ?></h1>

    <div id="data-container">
        <!-- Data will be dynamically updated here -->
        <table border="1">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Level (cm)</th>
                    <th>Weight (kg)</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Plastic</td>
                    <td id="plastic-level">N/A</td>
                    <td id="plastic-weight">N/A</td>
                    <td id="plastic-timestamp">N/A</td>
                </tr>
                <tr>
                    <td>Metal</td>
                    <td id="metal-level">N/A</td>
                    <td id="metal-weight">N/A</td>
                    <td id="metal-timestamp">N/A</td>
                </tr>
                <tr>
                    <td>Paper</td>
                    <td id="paper-level">N/A</td>
                    <td id="paper-weight">N/A</td>
                    <td id="paper-timestamp">N/A</td>
                </tr>
                <tr>
                    <td>Glass</td>
                    <td id="glass-level">N/A</td>
                    <td id="glass-weight">N/A</td>
                    <td id="glass-timestamp">N/A</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch data using AJAX
        function fetchData() {
            $.ajax({
                url: 'fetch_data.php', // Make sure the path is correct
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Update the data in the table with real-time values
                    $('#plastic-level').text(data.plastic ? data.plastic.level : 'N/A');
                    $('#plastic-weight').text(data.plastic ? data.plastic.weight : 'N/A');
                    $('#plastic-timestamp').text(data.plastic ? data.plastic.timestamp : 'N/A');
                    
                    $('#metal-level').text(data.metal ? data.metal.level : 'N/A');
                    $('#metal-weight').text(data.metal ? data.metal.weight : 'N/A');
                    $('#metal-timestamp').text(data.metal ? data.metal.timestamp : 'N/A');
                    
                    $('#paper-level').text(data.paper ? data.paper.level : 'N/A');
                    $('#paper-weight').text(data.paper ? data.paper.weight : 'N/A');
                    $('#paper-timestamp').text(data.paper ? data.paper.timestamp : 'N/A');
                    
                    $('#glass-level').text(data.glass ? data.glass.level : 'N/A');
                    $('#glass-weight').text(data.glass ? data.glass.weight : 'N/A');
                    $('#glass-timestamp').text(data.glass ? data.glass.timestamp : 'N/A');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Call fetchData every 5 seconds (5000 milliseconds)
        setInterval(fetchData, 5000); // Adjust the interval as needed

        // Fetch data on page load
        $(document).ready(function() {
            fetchData();
        });
    </script>
</body>
</html>
