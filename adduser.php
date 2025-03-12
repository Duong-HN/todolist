<?php 
    include 'database.php';

    $username = $_POST['username'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    $usercaptcha = $_POST['captcha'];
    $captcha = $_SESSION['captcha'];
   
    if(strcmp($usercaptcha,$captcha)==0)
    {
        if(strcmp($pass1,$pass2)==0) {
            createUser($username, $pass1);
        }
        else {
            $_SESSION['error'] = "&nbsp; Mật khẩu không khớp";
            header('location:signup.php');
        }
    }
    else {
        $_SESSION['error'] = "&nbsp; Captcha không đúng.";
        header('location:signup.php');
    }
 ?>


