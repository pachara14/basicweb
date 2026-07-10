<?php
include 'connect.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    $stmt->close();
} else {
    $user = null;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            ร้านค้าออนไลน์
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="dashboard.php">หน้าแรก</a>
                </li>
                
                <li class="nav-item me-4">
                    <a class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" href="add.php">
                        + เพิ่มสินค้า
                    </a>
                </li>
                
                <?php if ($user): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        <?php if (!empty($user['profile_image'])): ?>
                            <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile" width="38" height="38" class="rounded-circle me-2 border border-2 border-secondary" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 38px; height: 38px; font-weight: bold; font-size: 16px;">
                                <?= strtoupper(substr($user['username'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        
                        <span class="fw-semibold"><?= htmlspecialchars($user['username']) ?></span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item py-2" href="profile.php">โปรไฟล์ส่วนตัว</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="logout.php">ออกจากระบบ</a></li>
                    </ul>
                </li>
                <?php else: ?>
                    <li class="nav-item ms-3">
                        <span class="navbar-text text-white">สวัสดี, ผู้ใช้</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>