<?php
    session_start();
    
    // ล้างค่าตัวแปรใน Session ทั้งหมด (เช่น $_SESSION['user_id'])
    session_unset(); 
    
    // ทำลาย Session ทิ้ง
    session_destroy(); 
    
    // เด้งกลับไปที่หน้าแรก หรือหน้า Login
    header("Location: index.php"); 
    exit();
?>