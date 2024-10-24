<?php
// template.php
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Adjust this value to match the header height */
        }
        #header {
            width: 100%;
            background-color: #760b9a;
            color: white;
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            padding: 0 20px; /* Maintain padding for header */
            box-sizing: border-box;
        }
        #header .logo-space {
            width: 50px; /* Adjust this width based on your logo size */
            height: 50px; /* Match logo height */
        }
        #header .logo-space img {
            width: 100%; /* Make logo fill the space */
            height: auto; /* Maintain aspect ratio */
        }
        #header .brand-name {
            font-size: 30px; /* Smaller font size */
            font-weight: bold; /* Make it bolder */
            margin: 0; /* Remove default margin */
            padding-left: 5px; /* Minimal padding to separate from logo space */
        }
        #header .logout-button {
            margin-left: auto; /* Pushes the logout button to the far right */
            color: white;
            text-decoration: none;
            padding: 10px 15px; /* Optional padding for the logout button */
        }
        #sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 15px;
            top: 60px; /* Adjust this value to match the header height */
        }
        #sidebar h2 {
            color: white;
        }
        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        #sidebar ul li {
            margin: 10px 0;
        }
        #sidebar ul li a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
        }
        #sidebar ul li a.active {
            font-weight: bold;
            background-color: #575757;
        }
        #sidebar ul li a:hover {
            background-color: #575757;
        }
        #content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
    </style>
</head>
<body>
    <div id="header">
        <div class="logo-space">
            <img src="images/logo-3.png" alt="Company Logo">
        </div>
        <div class="brand-name">TrashTech</div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <?php include 'sidebar.php'; ?>
    <div id="content">
        <?php echo $page_content; ?>
    </div>
</body>
</html>

