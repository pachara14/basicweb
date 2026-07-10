<?php
include 'connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {


}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_path = NULL;

    // จัดการอัปโหลดรูปภาพ
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/store/";
        if (!is_dir($target_dir)) mkdir($target_dir);

        $image_path = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    // บันทึกลงฐานข้อมูลแบบ Prepared Statement
    $stmt = $conn->prepare("INSERT INTO products (name, price, image_path) VALUES (?, ?, ?)");
    // "sds" หมายถึง String, Double (ตัวเลขทศนิยม), String
    $stmt->bind_param("sds", $name, $price, $image_path);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h3 class="mb-4">เพิ่มสินค้าใหม่</h3>
                <form action="add.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">ชื่อสินค้า</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ราคา</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">รูปภาพสินค้า</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">บันทึกสินค้า</button>
                    <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">กลับไปหน้าแรก</a>
                </form>
            </div>
        </div>
    </div>
    </div> <?php include 'footer.php'; ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>