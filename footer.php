<?php
// ตั้งค่าโซนเวลา (ถ้าในไฟล์ connect.php มีตั้งไว้แล้ว ไม่ต้องใส่ซ้ำก็ได้ครับ)
date_default_timezone_set('Asia/Bangkok');
?>
<footer class="bg-dark text-white text-center py-4 mt-auto shadow-sm">
    <div class="container">
        <p class="mb-1">&copy; <?= date('Y') ?> ร้านค้าออนไลน์ All rights reserved.</p>

        <p class="mb-0 text-info small">
            อัปเดตล่าสุด: <?= date('d/m/Y H:i:s') ?>
        </p>

        <small class="text-secondary">ระบบจัดการสินค้าเวอร์ชัน 1.0</small>
    </div>
</footer>