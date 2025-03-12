<?php 
    include('default.html');
    include('database.php');

    if(loggedin()) {
        header("location:todo.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> New User </title>
    </head>
    <body>
        <p style="white-space:pre">  Already have an account <a href="login.php" title="Login" style="color: red;text-decoration: none"> Login </a> </p>
    
        <?php error(); ?>

        <form action="adduser.php" method="POST">
        <center>
    <form action="valid.php" method="POST">
        <fieldset>
            <legend style="color: blue;">New User</legend>
            <table>
                <tbody>
                    <tr>
                        <td><pre>Student ID </pre></td>
                        <td><input type="text" name="username" placeholder="Duong" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td><pre>Password </pre></td>
                        <td><input type="password" required name="password1" placeholder="*******"></td>
                    </tr>
                    <tr>
                        <td><pre>Confirm Password </pre></td>
                        <td><input type="password" required name="password2" placeholder="*******"></td>
                    </tr>
                    <tr>
                        <td>
                            <?php                            
                                $capcode = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz"), 0, 6);
                                $_SESSION['captcha'] = $capcode;
                                echo '<div class="captcha">'.$capcode.'</div>';
                            ?>
                        </td>
                        <td><input type="text" name="captcha" placeholder="Enter captcha" autocomplete="off" required></td>
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

<style>
    input[type="text"], input[type="password"] {
        width: 250px; height: 40px; border-radius: 20px; 
        border: 1px solid gray; padding-left: 10px; font-size: 16px;
    }
    input[type="submit"], input[type="reset"] {
        background: lightblue; border: none; border-radius: 20px;
        width: 100px; height: 40px; font-size: 16px; cursor: pointer;
    }
    input[type="submit"]:hover, input[type="reset"]:hover { background: #87CEFA; }
    .captcha { font-size: 20px; font-weight: bold; color: red; }
</style>


        </form>
    </body>
</html>