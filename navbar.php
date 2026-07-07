<?php
include 'connect.php';

// ป้องกันกรณีที่ยังไม่ได้ล็อกอินแล้วเผลอเปิดไฟล์นี้
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    // ถ้าไม่มี Session อาจจะกำหนดให้ $user เป็น null หรือเด้งไปหน้า Login
    $user = null;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">ร้านค้าออนไลน์</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">หน้าแรก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">เพิ่มสินค้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">โปรไฟล์</a>
                </li>

                

                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">ออกจากระบบ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>