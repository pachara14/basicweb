<?php
include 'connect.php';

// 1. ตรวจสอบว่าส่ง ID มาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// 2. ดึงข้อมูลสินค้าเดิมเพื่อนำไปแสดงในฟอร์ม
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("ไม่พบสินค้านี้");
}

// 3. จัดการเมื่อมีการกดปุ่ม "บันทึกการแก้ไข" (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_path = $product['image_path']; // ใช้รูปเดิมเป็นค่าเริ่มต้น

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่เข้ามาไหม
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/store/";
        if (!is_dir($target_dir)) mkdir($target_dir);

        // ลบรูปภาพเก่าออกจากโฟลเดอร์ (ถ้ามีอยู่จริง)
        if (!empty($product['image_path']) && file_exists($product['image_path'])) {
            unlink($product['image_path']);
        }

        // ตั้งชื่อไฟล์ใหม่และอัปโหลด
        $image_path = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    // อัปเดตข้อมูลลงฐานข้อมูล
    $stmt_update = $conn->prepare("UPDATE products SET name = ?, price = ?, image_path = ? WHERE id = ?");
    $stmt_update->bind_param("sdsi", $name, $price, $image_path, $id);

    if ($stmt_update->execute()) {
        $_SESSION['success'] = "แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว";
    }
    $stmt_update->close();

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>แก้ไขสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h3 class="mb-4">แก้ไขข้อมูลสินค้า</h3>

                <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">ชื่อสินค้า</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ราคา</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">รูปภาพปัจจุบัน</label>
                        <div class="mb-2">
                            <?php if (!empty($product['image_path'])): ?>
                                <img src="<?= htmlspecialchars($product['image_path']) ?>" width="120" class="img-thumbnail d-block">
                            <?php else: ?>
                                <span class="text-muted small">ไม่มีรูปภาพเก่า</span>
                            <?php endif; ?>
                        </div>
                        <label class="form-label text-primary">อัปโหลดรูปภาพใหม่ (ถ้าต้องการเปลี่ยน)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-warning w-100 text-white">บันทึกการแก้ไข</button>
                    <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">ยกเลิก</a>
                </form>

            </div>
        </div>
    </div>
</body>

</html>