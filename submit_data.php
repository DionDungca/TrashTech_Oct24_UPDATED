<?php 
// Include the database connection
include 'db_connection.php';

// Start the session
session_start(); 

// Check if user ID is set in session
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details (including company_name) from the database based on user_id
$stmt = $conn->prepare("SELECT company_name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id); // Assuming user_id is an integer
$stmt->execute();
$stmt->bind_result($company_name);
$stmt->fetch();
$stmt->close();

// Check if user details were retrieved successfully
if (empty($company_name)) {
    die("Error: Company name not found for the user.");
}

// Debugging information - remove or comment out in production

echo "Company Name: " . htmlspecialchars($company_name) . "<br>";

// Debugging: Display the posted data
echo "<h3>Posted Data:</h3>";
var_dump($_POST); // Output all POST data
echo "<br>";

// Initialize variables with default values (or use your input method)
$glass_level = isset($_POST['glass_level']) ? $_POST['glass_level'] : null;
$glass_weight = isset($_POST['glass_weight']) ? $_POST['glass_weight'] : null;
$metal_level = isset($_POST['metal_level']) ? $_POST['metal_level'] : null;
$metal_weight = isset($_POST['metal_weight']) ? $_POST['metal_weight'] : null;
$plastic_level = isset($_POST['plastic_level']) ? $_POST['plastic_level'] : null;
$plastic_weight = isset($_POST['plastic_weight']) ? $_POST['plastic_weight'] : null;
$paper_level = isset($_POST['paper_level']) ? $_POST['paper_level'] : null;
$paper_weight = isset($_POST['paper_weight']) ? $_POST['paper_weight'] : null;

// Function to insert data
function insertData($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    // Execute and check for errors
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Prepare and execute statements for each bin type
if ($glass_level !== null) {
    insertData($conn, "INSERT INTO glass_level (level, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$glass_level, $company_name]);
}

if ($glass_weight !== null) {
    insertData($conn, "INSERT INTO glass_weight (weight, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$glass_weight, $company_name]);
}

if ($metal_level !== null) {
    insertData($conn, "INSERT INTO metal_level (level, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$metal_level, $company_name]);
}

if ($metal_weight !== null) {
    insertData($conn, "INSERT INTO metal_weight (weight, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$metal_weight, $company_name]);
}

if ($plastic_level !== null) {
    insertData($conn, "INSERT INTO plastic_level (level, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$plastic_level, $company_name]);
}

if ($plastic_weight !== null) {
    insertData($conn, "INSERT INTO plastic_weight (weight, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$plastic_weight, $company_name]);
}

if ($paper_level !== null) {
    insertData($conn, "INSERT INTO paper_level (level, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$paper_level, $company_name]);
}

if ($paper_weight !== null) {
    insertData($conn, "INSERT INTO paper_weight (weight, company_name, date, timestamp) VALUES (?, ?, CURDATE(), NOW())", 
        [$paper_weight, $company_name]);
}

// Close the connection
$conn->close();
?>
