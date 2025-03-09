<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Todo Application Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        header {
            background: #007bff;
            color: #fff;
            padding: 20px 20px;
            position: relative;
        }
        header h1 {
            margin: 0;
        }
        .auth-links {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .auth-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        main {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        footer {
            background: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Todo Application Project</h1>
        <div class="auth-links">
            <a href="login.php">Login</a>
            <a href="newuser.php">Sign Up</a>
        </div>
    </header>
    
    <main>
        <h2>About This Project</h2>
        <p>
            This is a simple Todo Application built with PHP and MySQL. It allows users to manage their tasks by adding, editing, and deleting them.
        </p>
        <p>
            <strong>Features:</strong>
        </p>
        <ul>
            <li>User Registration and Login</li>
            <li>Add, Edit, Delete Todo Items</li>
            <li>Admin Dashboard for User Management</li>
            <li>Password Management and Captcha Verification</li>
        </ul>
        <p>
            Explore the project to learn how to build a dynamic web application with PHP!
        </p>
    </main>
    
    <footer>
        &copy; <?php echo date("Y"); ?> Todo Application Project. All rights reserved.
    </footer>
</body>
</html>
