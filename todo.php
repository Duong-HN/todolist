<?php 
    include('database.php');
    include('default.html');

    if (!loggedin()) {
        header("Location: login.php");
        exit();
    }

    // Xác định user đích để hiển thị todolist:
    // Nếu admin và có GET parameter 'username', dùng giá trị đó,
    // ngược lại, dùng username trong session
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_GET['username'])) {
        $targetUser = $_GET['username'];
    } else {
        $targetUser = $_SESSION['username'];
    }

    // Các liên kết điều hướng
    echo '<br> <a href="logout.php" align="right" title="Logout" style="color: red; text-decoration: none">&nbsp; Logout </a>';
    echo '<a href="changepassword.php" align="right" title="change password" style="color: blue; text-decoration: none">&nbsp; Change Password </a>';
    echo '<a href="deleteaccount.php" align="right" title="delete account" style="color: blue; text-decoration: none">&nbsp; Delete Account </a> <br>';

    error();

    // Hiển thị thông điệp: nếu admin đang xem todolist của user khác
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $targetUser !== $_SESSION['username']) {
        echo "<br> <center id='user'> Viewing Todo list for user: " . ucwords($targetUser) . "</center> <br>";
    } else {
        echo "<div style='margin: 0; padding: 0; background: transparent; text-align: center;'>Welcome " . ucwords($targetUser) . "</div>";

    }

    // Xử lý form thêm task: dùng $targetUser làm đối tượng thêm task
    if (isset($_POST['addtask'])) {
        if (!empty($_POST['description'])) {
            addTodoItem($targetUser, $_POST['description']);
            header("Refresh:0");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TODO for <?php echo htmlspecialchars($targetUser); ?></title>
</head>
<body>
    <br>
    <!-- Ghi chú: Nếu admin đang xem todolist của user khác, hãy giữ lại GET parameter 'username' -->
    <form action="todo.php<?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_GET['username'])) ? '?username=' . urlencode($_GET['username']) : ''; ?>" method="POST">
        <?php spaces(30); ?>
        <input type="text" size="50" placeholder=" Title" name="description" autocomplete="off" required/>  
        <input type="submit" name="addtask" value="Add"/>
    </form>
</body>
</html>

<?php
    // Hiển thị danh sách todo của $targetUser
    getTodoItems($targetUser);
?>
