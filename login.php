<?php
session_start();
ob_start(); // Bắt đầu output buffering để tránh lỗi "headers already sent"

// Nếu bạn muốn hiển thị giao diện từ default.html, hãy include nó sau khi kiểm tra đăng nhập
// Nếu include default.html ngay bây giờ sẽ in ra nội dung, gây lỗi header(), vì vậy nên xử lý chuyển hướng trước:
include('database.php');

if (loggedin()) {
    // Kiểm tra role của user trong session (giả sử valid.php đã lưu $_SESSION['role'])
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: todo.php");
    }
    exit();
}

// Bây giờ có thể xuất giao diện HTML
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style type="text/css" media="screen">
        * {
            font-size: 21pt;
        }
        .unselectable { 
            -webkit-user-select: none; 
            -moz-user-select: none; 
            -ms-user-select: none; 
            user-select: none;    
            color: #cc0000;
        }
        input[type='submit'], input[type='reset'] {
            padding:5px 30px;
            background: #cce6ff;
            border: none;
            border-radius: 30px;
        }
        input[type='text'], input[type='password'] {
            padding: 10px;
            border: none;
            border-radius: 25px;
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Bạn có thể include default.html tại đây nếu muốn, hoặc copy nội dung của nó -->
    <?php include('default.html'); ?>
    
    <p style="white-space:pre">  Don't have an account? <a href="newuser.php" style="color: red; text-decoration: none">Create New Account</a> </p> 
    
    <?php error(); ?>

    <center>
        <form action="valid.php" method="POST">
            <fieldset>
                <legend style="color: blue;">Login</legend>
                <table>
                    <tbody>
                        <tr>
                            <td><pre>Name </pre></td>
                            <td>
                                <input size="25" type="text" name="username" placeholder="Duong" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td><pre>Password </pre></td>
                            <td>
                                <input size="25" type="password" name="password" placeholder="********" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php                            
                                    $capcode = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
                                    $capcode = substr(str_shuffle($capcode), 0, 6);
                                    $_SESSION['captcha'] = $capcode;
                                    echo '<div class="unselectable">'.$capcode.'</div>';
                                ?>
                            </td>
                            <td>
                                <input size="25" type="text" name="captcha" placeholder="Enter captcha" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="reset" value="Reset"></td>
                            <td><input type="submit" value="Submit"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>
    </center>
</body>
</html>
