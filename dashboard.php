<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: logout.php");
    exit();
}

$user_id = $_SESSION['user_id'];    
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$product_result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Dashboard สินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>ระบบจัดการสินค้า (Dashboard)</h2>
            <a href="add.php" class="btn btn-success">+ เพิ่มสินค้าใหม่</a>
        </div>

        <table class="table table-bordered table-white bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($product_result && $product_result->num_rows > 0): ?>
                    <?php while ($row = $product_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>" width="100" height="120" style="object-fit: cover; display: block; margin: 0 auto;"> <?php else: ?>
                                    ไม่มีรูป
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= number_format($row['price'], 2) ?> ฿</td>
                            <td>
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm text-white">รายละเอียด</a>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">แก้ไข</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสินค้านี้?');">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">ยังไม่มีข้อมูลสินค้า</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div> <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>