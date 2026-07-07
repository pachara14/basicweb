<?php
include 'connect.php';

// หาก Login อยู่แล้ว ให้ข้ามไปหน้าจัดการสินค้าเลย
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($email)) {
        $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    }
    elseif ($password !== $confirm_password) {
        $error = "รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()) {
            $error = "ชื่อผู้ใช้หรืออีเมลนี้มีในระบบแล้ว กรุณาใช้ชื่ออื่น";
        } else {
            
            // 4. จัดการอัปโหลดรูปภาพโปรไฟล์
            $imagePath = '';
            if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'images/';
                $fileName = time() . '_profile_' . basename($_FILES['images']['name']);
                $targetPath = $uploadDir . $fileName;
                // ย้ายไฟล์จาก temp ไปยังโฟลเดอร์ uploads
                if (move_uploaded_file($_FILES['images']['tmp_name'], $targetPath)) {
                    $imagePath = $targetPath;
                }
            }

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name, email, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $hashed_password, $first_name, $last_name, $email, $imagePath);
            
            if ($stmt->execute()) {
                $success = "สมัครสมาชิกสำเร็จ! <a href='index.php'>คลิกที่นี่เพื่อเข้าสู่ระบบ</a>";
            } else {
                $error = "เกิดข้อผิดพลาด ไม่สามารถสมัครสมาชิกได้";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>

<body>
    <div class="register-box">
        <h2 style="text-align: center; margin-top:0; color: #333;">สมัครสมาชิก</h2>

        <?php if ($error): ?>
            <div class="alert danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>ชื่อผู้ใช้ (Username):</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>ชื่อจริง (First Name):</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>นามสกุล (Last Name):</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>อีเมล (Email):</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>รูปโปรไฟล์ (Image):</label>
                    <input type="file" name="images" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>รหัสผ่าน (Password):</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน (Confirm Password):</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <button type="submit">ยืนยันการสมัครสมาชิก</button>
            </form>
        <?php endif; ?>

        <div class="login-link">
            มีบัญชีอยู่แล้ว? <a href="index.php">เข้าสู่ระบบที่นี่</a>
        </div>
    </div>
</body>

</html>