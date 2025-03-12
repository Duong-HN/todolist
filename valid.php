<?php
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captchaInput = $_POST['captcha'];

    // Kiểm tra captcha
    if ($captchaInput !== $_SESSION['captcha']) {
        $_SESSION['error'] = "Captcha không đúng.";
        header("Location: login.php");
        exit();
    }
    
    // Xử lý đăng nhập (ví dụ: tìm user trong bảng users)
    $conn = connectdatabase();
    $usernameEsc = mysqli_real_escape_string($conn, $username);
    $sql = "SELECT * FROM users WHERE username = '$usernameEsc'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
        // Nếu sử dụng password không hash:
        if ($password === $userData['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $userData['role'];  // Lưu role vào session
            // Nếu admin, chuyển đến trang admin, ngược lại todo.php
            if ($userData['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: todo.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Sai mật khẩu.";
        }
    } else {
        $_SESSION['error'] = "Student ID không tồn tại.";
    }
    mysqli_close($conn);
    header("Location: login.php");
    exit();
}
?>
