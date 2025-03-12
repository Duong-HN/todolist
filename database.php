<?php
// Kiểm tra session trước khi start (chỉ gọi 1 lần)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* 
   Nếu bạn vẫn cần xử lý $_POST['Delete'] hay $_POST['Save'] ở đây, 
   thì đoạn code này sẽ thực hiện ngay khi include file này.
   Nhưng tốt hơn là đặt logic này trong file todo.php hoặc file xử lý riêng.
*/
if (isset($_POST['Delete'])) {
    if (!empty($_POST['check_list'])) {
        $tasks = $_POST['check_list'];
        foreach ($tasks as $taskId) {
            deleteTodoItem($_SESSION['username'], $taskId);
        }
    }
} else if (isset($_POST['Save'])) {
    $conn = connectdatabase();
    $sql = "UPDATE todo.tasks SET done = 0";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    if (!empty($_POST['check_list'])) {
        $tasks = $_POST['check_list'];
        foreach ($tasks as $taskId) {
            updateDone($taskId);
        }
    }
}

/**
 * Hàm kết nối CSDL
 */
function connectdatabase() {
    // Thay đổi thông tin host, user, pass, db theo môi trường của bạn
    return mysqli_connect("127.0.0.1:3306", "duong", "matkhau", "todo");
}

/**
 * Kiểm tra đăng nhập
 */
function loggedin() {
    return isset($_SESSION['username']);
}

/**
 * Đăng xuất
 */
function logout() {
    $_SESSION['error'] = "&nbsp; Successfully logged out !!";
    unset($_SESSION['username']);
}

/**
 * Xuất khoảng trắng
 */
function spaces($n) {
    for ($i = 0; $i < $n; $i++) {
        echo "&nbsp;";
    }
}

/**
 * Kiểm tra user có tồn tại không
 */
function userexist($username) {
    $conn = connectdatabase();
    $sql = "SELECT * FROM todo.users WHERE username = '".mysqli_real_escape_string($conn, $username)."'";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if (!$result || mysqli_num_rows($result) == 0) {
        return false;
    }
    return true;
}

/**
 * Kiểm tra username + password
 */
function validuser($username, $password) {
    $conn = connectdatabase();
    $sql = "SELECT * FROM todo.users 
            WHERE username = '".mysqli_real_escape_string($conn, $username)."'
              AND password = '".mysqli_real_escape_string($conn, $password)."'";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if (!$result || mysqli_num_rows($result) == 0) {
        return false;
    }
    return true;
}

/**
 * Hiển thị lỗi (nếu có)
 */
function error() {
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
}

/**
 * Đổi mật khẩu
 */
function updatepassword($username, $password) {
    $conn = connectdatabase();
    $sql = "UPDATE todo.users 
            SET password = '".mysqli_real_escape_string($conn, $password)."'
            WHERE username = '".mysqli_real_escape_string($conn, $username)."'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    $_SESSION['error'] = "<br> &nbsp; Đổi Password thành công";
    header('Location: todo.php');
    exit();
}

/**
 * Xoá tài khoản
 */
function deleteaccount($username) {
    $conn = connectdatabase();
    // Xoá tất cả tasks của user
    $sql = "DELETE FROM todo.tasks WHERE username = '".mysqli_real_escape_string($conn, $username)."'";
    mysqli_query($conn, $sql);

    // Xoá user
    $sql = "DELETE FROM todo.users WHERE username = '".mysqli_real_escape_string($conn, $username)."'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    $_SESSION['error'] = "&nbsp; Account Deleted !! ";
    unset($_SESSION['username']);
    header('Location: login.php');
    exit();
}

/**
 * Tạo user mới
 */
function createUser($username, $password) {
    if (!userexist($username)) {
        $conn = connectdatabase();
        $sql = "INSERT INTO todo.users (username, password)
                VALUES ('".mysqli_real_escape_string($conn, $username)."', 
                        '".mysqli_real_escape_string($conn, $password)."')";
        mysqli_query($conn, $sql);
        mysqli_close($conn);

        $_SESSION["username"] = $username;
        header('Location: todo.php');
        exit();
    } else {
        $_SESSION['error'] = "&nbsp; Người dùng đã tồn tại. ";
        header('Location: signup.php');
        exit();
    }
}

/**
 * Xác thực user (kèm captcha)
 */
function isValid($username, $password, $usercaptcha) {
    if (!isset($_SESSION['captcha']) || $usercaptcha !== $_SESSION['captcha']) {
        $_SESSION['error'] = "&nbsp; Captcha không đúng. ";
        header('Location: login.php');
        exit();
    }

    // Captcha đúng, kiểm tra user
    if (validuser($username, $password)) {
        $_SESSION["username"] = $username;
        header('Location: todo.php');
        exit();
    } else {
        $_SESSION['error'] = "&nbsp; Invalid Username or Password !! ";
        header('Location: login.php');
        exit();
    }
}

/**
 * Lấy danh sách tasks của user
 */
function getTodoItems($username) {
    $conn = connectdatabase();
    $sql = "SELECT * FROM todo.tasks 
            WHERE username = '".mysqli_real_escape_string($conn, $username)."'";
    $result = mysqli_query($conn, $sql);

    echo "<form method='POST'>";
    echo "<pre>";
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            spaces(15);
            // Check task đã done hay chưa
            if ($row['done']) {
                echo "<input type='checkbox' checked class='largerCheckbox' name='check_list[]' value='".$row["taskid"]."'>";
            } else {
                echo "<input type='checkbox' class='largerCheckbox' name='check_list[]' value='".$row["taskid"]."'>";
            }
            echo "<td> " . htmlspecialchars($row["task"]) . "</td>";
            echo "<br>";
        }
    }
    echo "</pre> <hr>";
    spaces(35);
    echo "<input type='submit' name='Delete' value='Delete'/>";
    spaces(10);
    echo "<input type='submit' name='Save' value='Save'/>";
    echo "</form>";
    echo "<br><br>";

    mysqli_close($conn);
}

/**
 * Thêm task
 */
function addTodoItem($username, $todo_text) {
    $conn = connectdatabase();
    $sql = "INSERT INTO todo.tasks(username, task, done)
            VALUES ('".mysqli_real_escape_string($conn, $username)."', 
                    '".mysqli_real_escape_string($conn, $todo_text)."', 0)";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

/**
 * Xoá task
 */
function deleteTodoItem($username, $todo_id) {
    $conn = connectdatabase();
    $sql = "DELETE FROM todo.tasks 
            WHERE taskid = '".mysqli_real_escape_string($conn, $todo_id)."'
              AND username = '".mysqli_real_escape_string($conn, $username)."'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

/**
 * Đánh dấu task đã xong
 */
function updateDone($todo_id) {
    $conn = connectdatabase();
    $sql = "UPDATE todo.tasks 
            SET done = 1 
            WHERE taskid = '".mysqli_real_escape_string($conn, $todo_id)."'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
