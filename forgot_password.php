<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';

$message = "";
$msg_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม (ช่องเดียว ใช้เช็คทั้ง Username และ Email)
    $identifier = trim($_POST['identifier']); 
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "รหัสผ่านใหม่ไม่ตรงกัน กรุณาลองอีกครั้ง";
        $msg_type = "danger";
    } else {
        // ใช้คำสั่ง OR เพื่อหาว่าตรงกับ username หรือ email อย่างใดอย่างหนึ่งหรือไม่
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        // ใส่ $identifier ลงไป 2 ตัว เพื่อแทนค่า ? ทั้งสองจุด
        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
            
            // เข้ารหัสผ่านใหม่เพื่อความปลอดภัย
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // อัปเดตรหัสผ่านลงฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($update_stmt->execute()) {
                $message = "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว! คุณสามารถเข้าสู่ระบบด้วยรหัสผ่านใหม่ได้เลย";
                $msg_type = "success";
            } else {
                $message = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
                $msg_type = "danger";
            }
            $update_stmt->close();
        } else {
            $message = "ไม่พบข้อมูลผู้ใช้งาน หรือ อีเมลนี้ในระบบ";
            $msg_type = "danger";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลืมรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">ลืมรหัสผ่าน</h3>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $msg_type ?>" role="alert">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form action="forgot_password.php" method="POST">
        <div class="mb-3">
            <label class="form-label">ชื่อผู้ใช้งาน หรือ อีเมล</label>
            <input type="text" name="identifier" class="form-control" required placeholder="กรอก Username หรือ Email">
        </div>
        <hr>
        <div class="mb-3">
            <label class="form-label">รหัสผ่านใหม่</label>
            <input type="password" name="new_password" class="form-control" required placeholder="ตั้งรหัสผ่านใหม่">
        </div>
        <div class="mb-3">
            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" name="confirm_password" class="form-control" required placeholder="พิมพ์รหัสผ่านใหม่อีกครั้ง">
        </div>
        
        <button type="submit" class="btn btn-primary w-100">บันทึกรหัสผ่านใหม่</button>
    </form>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">กลับไปหน้าเข้าสู่ระบบ</a>
    </div>
</div>

</body>
</html>