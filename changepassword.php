<?php 
    include('default.html');
    include('database.php');
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Chỉ khởi động session nếu chưa được khởi động
    }

    if(!loggedin()) {
    	header("location:login.php");
    }

    echo '<br> <a href="todo.php" align="right" style="color: red; text-decoration: none">&nbsp; Back to list </a>';

	$username = $_SESSION['username'];
	echo "<br> <center id='user'> Welcome ".ucwords($username)."</center> <br>";

    error();

    // Chỉ tạo Captcha mới nếu chưa có hoặc khi trang được tải lại lần đầu
    if (!isset($_SESSION['captcha'])) {
        $capcode = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        $capcode = substr(str_shuffle($capcode), 0, 6);
        $_SESSION['captcha'] = $capcode;
    }

	if(isset($_POST['change']))
	{
		$old = $_POST['oldpass'];
		$new = $_POST['newpass'];
        $captcha_input = $_POST['captcha'];

        // Kiểm tra Captcha
        if ($captcha_input !== $_SESSION['captcha']) {
            $_SESSION['error'] = "Captcha không đúng. Vui lòng thử lại.";
            header("Refresh:0");
            exit();
        }
        
        // Reset Captcha sau khi xác thực để tránh sử dụng lại
        unset($_SESSION['captcha']);

		$conn = connectdatabase();
	    $sql = "SELECT password FROM users WHERE username = '".$username."'"; 
	    $result = mysqli_query($conn,$sql);

    	$row = mysqli_fetch_assoc($result);
	    $actual = $row['password'];
	   
	   	if(strcmp($old,$actual)==0) {
	   		updatepassword($username, $new);
	   	}
	   	else {
	   		$_SESSION['error'] = "&nbsp; Invalid old password !!";
	        header("Refresh:0");
	   	}
	    mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Change Password </title>
    <style>
        fieldset {
            width: 350px;
            background: linear-gradient(to right,rgb(247, 254, 34),rgb(255, 0, 0));
            padding: 20px;
            border-radius: 10px;
        }
        legend {
            color: blue;
        }
        input[type="reset"], input[type="submit"] {
            background-color: lightblue;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 16px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .unselectable {
            color: red;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
<center>
    <form method="POST">
        <fieldset>
            <legend>Change Password</legend>
            <table>
                <tr>
                    <td><pre>Name </pre></td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td><pre>Old Password </pre></td>
                    <td>
                        <input type="password" name="oldpass" required>
                    </td>
                </tr>
                <tr>
                    <td><pre>New Password </pre></td>
                    <td>
                        <input type="password" name="newpass" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="unselectable"><?php echo $_SESSION['captcha']; ?></div>
                    </td>
                    <td>
                        <input type="text" name="captcha" placeholder="Enter captcha" autocomplete="off" required>
                    </td>
                </tr>
                <tr>
                    <td><input type="reset" value="Reset"></td>
                    <td><input type="submit" name="change" value="Submit"></td>
                </tr>
            </table>
        </fieldset>
    </form>
</center>
</body>
</html>