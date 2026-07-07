<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ป้องกันเบื้องต้นโดยแปลงเป็นตัวเลข
    
    // ดึงข้อมูลรูปภาพมาลบออกจากโฟลเดอร์ด้วย
    $stmt = $conn->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" หมายถึง Integer
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product && !empty($product['image_path']) && file_exists($product['image_path'])) {
        unlink($product['image_path']); // ลบไฟล์รูป
    }

    // ลบข้อมูลจากฐานข้อมูล
    $stmt_del = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt_del->bind_param("i", $id);
    $stmt_del->execute();
    $stmt_del->close();
}

$conn->close();
header("Location: dashboard.php");
exit();
?>