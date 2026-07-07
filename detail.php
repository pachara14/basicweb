<?php
include 'connect.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("ไม่พบสินค้านี้");
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body text-center">
                <?php if (!empty($product['image_path'])): ?>
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" class="img-fluid rounded mb-3" style="max-height: 300px;">
                <?php else: ?>
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center mb-3 rounded" style="height: 200px;">ไม่มีรูปภาพ</div>
                <?php endif; ?>

                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <h4 class="text-success mb-4"><?= number_format($product['price'], 2) ?> บาท</h4>

                <p class="text-muted">เพิ่มเข้าระบบเมื่อ: <?= $product['created_at'] ?></p>

                <a href="dashboard.php" class="btn btn-secondary">กลับไปหน้า Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>