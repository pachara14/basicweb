<?php
include 'connect.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. เตรียมคำสั่งแบบ MySQLi
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    
    // 2. แนบตัวแปร (s = string)
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // 3. ดึงผลลัพธ์ออกมาเป็น Associative Array
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // ตรวจสอบรหัสผ่าน
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div class="login-box">
        <h2 style="text-align: center; margin-top:0; color: #333;">เข้าสู่ระบบ</h2>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>ชื่อผู้ใช้:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>รหัสผ่าน:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p style="text-align: center; margin-top: 10px;">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
            <p style="text-align: center; margin-top: 10px;"><a href="forgot_password.php">ลืมรหัสผ่าน?</a></p>
        </form>
    </div>
</body>
</html>