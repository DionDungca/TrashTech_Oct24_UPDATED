<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div id="sidebar">
    <h2><?php echo htmlspecialchars($_SESSION['company_name']); ?> Menu</h2> <!-- Display the company name -->
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h3>Admin Menu</h3>
        <ul>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="waste_statistics.php" class="<?php echo $current_page == 'waste_statistics.php' ? 'active' : ''; ?>">Waste Statistics</a></li>
            <li><a href="logs.php" class="<?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">Logs</a></li>
            <li><a href="bin_levels.php" class="<?php echo $current_page == 'bin_levels.php' ? 'active' : ''; ?>">Bin Levels</a></li>
            <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
            <li><a href="user_logs.php" class="<?php echo $current_page == 'user_logs.php' ? 'active' : ''; ?>">User Logs</a></li>
            <li><a href="about_us.php" class="<?php echo $current_page == 'about_us.php' ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="faq.php" class="<?php echo $current_page == 'faq.php' ? 'active' : ''; ?>">FAQ</a></li>
        </ul>
    <?php else: ?>
        <h3>User Menu</h3>
        <ul>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="bin_levels.php" class="<?php echo $current_page == 'bin_levels.php' ? 'active' : ''; ?>">Bin Levels</a></li>
            <li><a href="logs.php" class="<?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">Logs</a></li>
            <li><a href="about_us.php" class="<?php echo $current_page == 'about_us.php' ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="faq.php" class="<?php echo $current_page == 'faq.php' ? 'active' : ''; ?>">FAQ</a></li>
        </ul>
    <?php endif; ?>
</div>

<style>
    #sidebar {
        width: 200px; /* Set a fixed width for the sidebar */
        background-color: #2A2A2A; /* Dark gray background */
        color: white; /* Text color */
        padding: 10px; /* Padding for content */
        position: fixed; /* Fixed position */
        height: 100vh; /* Full height */
        overflow-y: auto; /* Scrollable if content overflows */
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5); /* Subtle shadow for depth */
    }

    h2 {
        margin-bottom: 20px; /* Space below the heading */
    }

    h3 {
        margin: 10px 0; /* Space above and below subheadings */
    }

    ul {
        list-style: none; /* Remove bullet points */
        padding: 0; /* Remove padding */
    }

    ul li {
        margin: 10px 0; /* Space between links */
    }

    ul li a {
        color: white; /* Link color */
        text-decoration: none; /* Remove underline */
        font-size: 16px; /* Font size for links */
        transition: color 0.3s; /* Smooth color transition */
    }

    ul li a:hover {
        color: #A1A1A1; /* Lighter gray on hover */
        text-decoration: underline; /* Underline on hover */
    }

    .active {
        font-weight: bold; /* Highlight the active link */
        text-decoration: underline; /* Underline active link */
    }
</style>
