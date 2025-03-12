<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Todo Application Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('img/phen.png') no-repeat center center fixed; 
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
            font-family: 'Georgia', serif;
        }
        .content {
            background-color: rgba(0, 0, 0, 0.7); 
            padding: 40px;
            border-radius: 15px;
            max-width: 600px;
            text-align: center;
        }
        .btn-custom {
            background-color: #cce6ff;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            color: #000;
            transition: none !important;
        }

    </style>
</head>
<body>
    <div class="content">
        <h1 class="display-4">Welcome to Todo Application Project</h1>
        <p class="lead">This project is built using PHP and MySQL to manage tasks efficiently.</p>
        <hr>
        <h3>Features</h3>
        <ul class="text-start">
            <li>User Registration and Login</li>
            <li>Add, Edit, Delete Todo Items</li>
            <li>Admin Dashboard for User Management</li>
            <li>Password Management and Captcha Verification</li>
        </ul>
        <div class="d-flex justify-content-center gap-3">
            <a href="login.php" class="btn btn-custom">Login</a>
            <a href="signup.php" class="btn btn-custom">Sign Up</a>
        </div>
    </div>
</body>
</html>