<?php
// manage_users.php
include 'db_connection.php'; // Ensure the database connection is included
include 'header.php';

// Ensure session_start() is only called once
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Retrieve company_name based on the username
$query = "SELECT company_name FROM users WHERE username = ? LIMIT 1"; // Use ? for mysqli
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

// Check if user information is retrieved successfully
if ($user_info) {
    $_SESSION['company_name'] = $user_info['company_name']; // Store company_name in session
} else {
    echo "User not found.";
    exit();
}

// Function to fetch users based on company_name
function fetchUsers($conn, $company_name) {
    $query = "SELECT * FROM users WHERE company_name = ?"; // Use ? for mysqli
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $role = $_POST['role'];
    $id = $_POST['id'] ?? null;

    if (isset($_POST['create'])) {
        $password = ($role == 'admin') ? 'admin' : $_POST['password'];

        // Password validation
        if ($role != 'admin' && (strlen($password) < 8 || strlen($password) > 16 || 
            !preg_match('/[A-Z]/', $password) || 
            !preg_match('/[a-z]/', $password) || 
            !preg_match('/[0-9]/', $password))) {
            die("Password does not meet the requirements.");
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $sql = "INSERT INTO users (username, email, password, company_name, company_address, role) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $hashed_password, $company_name, $company_address, $role);
        $stmt->execute();

        echo "New user created successfully";
    } elseif (isset($_POST['update'])) {
        $hashed_password = ($role == 'admin') ? password_hash('admin', PASSWORD_DEFAULT) : null;

        $sql = "UPDATE users SET username=?, email=?, company_name=?, company_address=?, role=?" .
                ($hashed_password ? ", password=?" : "") . " WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        
        if ($hashed_password) {
            $stmt->bind_param("ssssssi", $username, $email, $company_name, $company_address, $role, $hashed_password, $id);
        } else {
            $stmt->bind_param("sssss", $username, $email, $company_name, $company_address, $role, $id);
        }
        
        $stmt->execute();

        echo "User updated successfully";
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "User deleted successfully";
    }
}

// Fetch users for the logged-in admin's company
$users = fetchUsers($conn, $_SESSION['company_name']);

$page_title = "Manage Users";
$page_content = '
    <h1>Manage Users</h1>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Company Name</th>
            <th>Company Address</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>';

foreach ($users as $row) {
    $page_content .= '
        <tr>
            <form method="POST" action="manage_users.php">
                <td><input type="text" name="username" value="' . htmlspecialchars($row['username']) . '"></td>
                <td><input type="email" name="email" value="' . htmlspecialchars($row['email']) . '"></td>
                <td><input type="text" name="company_name" value="' . htmlspecialchars($row['company_name']) . '"></td>
                <td><input type="text" name="company_address" value="' . htmlspecialchars($row['company_address']) . '"></td>
                <td>
                    <select name="role">
                        <option value="user" ' . ($row['role'] == 'user' ? 'selected' : '') . '>User</option>
                        <option value="admin" ' . ($row['role'] == 'admin' ? 'selected' : '') . '>Admin</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                    <input type="password" name="password" placeholder="New Password">
                    <button type="submit" name="update">Update</button>
                    <button type="submit" name="delete">Delete</button>
                </td>
            </form>
        </tr>';
}

$page_content .= '
    </table>';

include 'template.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding-top: 60px; /* Adjust this value to match the header height */
        display: flex;
    }
    #content {
        margin-left: 280px; /* Shift content more to the right */
        padding: 20px;
        width: calc(100% - 280px); /* Adjust content width */
        background: linear-gradient(135deg, #D187F5, #FFFFFF);
    }
    h1 {
        margin-top: 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
</style>
