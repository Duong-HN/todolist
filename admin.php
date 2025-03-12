<?php
session_start();
include('database.php');

// Kiểm tra xem người dùng có phải admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = connectdatabase();

// Lấy danh sách user (username, password, role)
// Vì username là khóa chính, ta ORDER BY username
$sql = "SELECT username, password, role FROM users ORDER BY username ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #ccc; 
            padding: 8px; 
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: blue;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .logout {
            text-align: center;
            margin-top: 15px;
        }
        .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p style="text-align:center;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</p>
    
    <table>
        <tr>
            <th>Username (PK)</th>
            <th>Password</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['password']); ?></td>
            <td><?php echo htmlspecialchars($row['role']); ?></td>
            <td class="actions">
                <!-- Khi ấn Edit, chuyển đến todo.php với GET parameter username -->
                <a href="todo.php?username=<?php echo urlencode($row['username']); ?>">Edit</a> | 
                <a href="delete_user.php?username=<?php echo urlencode($row['username']); ?>"
                   onclick="return confirm('Are you sure you want to delete this user?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
