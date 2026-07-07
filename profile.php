<?php
require_once 'connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$msg_type = "";

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $profile_image = $user['profile_image'];

    // จัดการอัปโหลดรูปโปรไฟล์ใหม่
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!empty($user['profile_image']) && file_exists($user['profile_image'])) {
            unlink($user['profile_image']);
        }

        $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "user_" . $user_id . "_" . time() . "." . $file_extension;
        $profile_image = $target_dir . $new_filename;

        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image);
    }
    $update_stmt = $conn->prepare("UPDATE users SET email = ?, profile_image = ? WHERE id = ?");
    $update_stmt->bind_param("ssi", $email, $profile_image, $user_id);

    if ($update_stmt->execute()) {
        $message = "อัปเดตโปรไฟล์เรียบร้อยแล้ว!";
        $msg_type = "success";

        // ดึงข้อมูลใหม่มาแสดงทันที
        $user['email'] = $email;
        $user['profile_image'] = $profile_image;
    } else {
        $message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        $msg_type = "danger";
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>โปรไฟล์ส่วนตัว</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h3 class="mb-4 text-center">โปรไฟล์ส่วนตัว</h3>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $msg_type ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <form action="profile.php" method="POST" enctype="multipart/form-data">

                    <div class="text-center mb-4">
                        <?php if (!empty($user['profile_image'])): ?>
                            <img src="<?= htmlspecialchars($user['profile_image']) ?>" class="rounded-circle border" width="120" height="120" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                                <?= strtoupper(substr($user['username'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-primary">เปลี่ยนรูปโปรไฟล์</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน (Username)</label>
                        <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                        <small class="text-muted">ชื่อผู้ใช้งานไม่สามารถเปลี่ยนแปลงได้</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">อีเมล (Email)</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required placeholder="กรอกอีเมลของคุณ">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">บันทึกข้อมูล</button>
                    <a href="dashboard.php" class="btn btn-secondary w-100">กลับไปหน้า Dashboard</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>