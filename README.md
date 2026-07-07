# 📦 basicweb - ระบบจัดการร้านค้าออนไลน์ (PHP & MySQL CRUD)
ระบบจัดการร้านค้าออนไลน์ขนาดเล็ก พัฒนาด้วยภาษา **PHP (OOP / Prepared Statements)** ร่วมกับฐานข้อมูล **MySQL** โดยมีการนำ **Bootstrap 5** และ Custom CSS มาใช้ในการออกแบบส่วนติดต่อผู้ใช้งาน (UI) ให้สวยงามและใช้งานง่าย
## ✨ คุณสมบัติของระบบ (Key Features)
### 👤 ระบบสมาชิกและโปรไฟล์ (User Authentication & Profile)
* **สมัครสมาชิก (Registration):** สมัครสมาชิกใหม่พร้อมอัปโหลดรูปภาพโปรไฟล์ (ระบบจะบันทึกรูปภาพไว้ในโฟลเดอร์ `images/`)
* **เข้าสู่ระบบ (Login):** เข้าสู่ระบบด้วยกลไก Session ปลอดภัยสูง ป้องกันการเข้าถึงหน้าจัดการหากยังไม่ได้เข้าสู่ระบบ
* **ออกจากระบบ (Logout):** สิ้นสุด Session และนำทางกลับสู่หน้าเข้าสู่ระบบ
* **ลืมรหัสผ่าน (Forgot Password):** ค้นหาบัญชีผู้ใช้ด้วย Username หรือ Email เพื่อตั้งรหัสผ่านใหม่ได้อย่างปลอดภัยด้วยการแฮชรหัสผ่านแบบ `PASSWORD_DEFAULT`
* **จัดการโปรไฟล์ (Profile Management):** ตรวจสอบข้อมูลส่วนตัว อัปเดตอีเมล และอัปโหลดเปลี่ยนรูปโปรไฟล์ใหม่ (รูปเก่าจะถูกลบอัตโนมัติเพื่อไม่ให้เปลืองพื้นที่เซิร์ฟเวอร์)
### 🛍️ ระบบจัดการสินค้า (Product Management CRUD)
* **แสดงแดชบอร์ดสินค้า (Dashboard):** ตารางแสดงรายการสินค้าทั้งหมดพร้อมรูปภาพประกอบ ชื่อสินค้า ราคา และเมนูการจัดการ
* **เพิ่มสินค้าใหม่ (Add Product):** เพิ่มชื่อสินค้า ราคา และรูปภาพสินค้า (รูปจะถูกจัดเก็บไว้ในโฟลเดอร์ `images/store/`)
* **ดูรายละเอียดสินค้า (Product Detail):** หน้าแสดงรูปภาพขนาดจริง ชื่อสินค้า ราคา และวันที่นำสินค้าเข้าสู่ระบบ
* **แก้ไขสินค้า (Edit Product):** ฟอร์มแก้ไขชื่อสินค้า ราคา และรูปภาพใหม่ (ลบไฟล์รูปเดิมออกจากโฟลเดอร์หากมีการเปลี่ยนรูปภาพใหม่)
* **ลบสินค้า (Delete Product):** ลบข้อมูลสินค้าออกจากฐานข้อมูลพร้อมลบไฟล์รูปภาพออกจากโฟลเดอร์เซิร์ฟเวอร์โดยอัตโนมัติ
---
## 📂 โครงสร้างของโปรเจกต์ (Project Structure)
```text
basicweb/
├── css/
│   ├── dashboard.css          # ไฟล์สไตล์สำหรับหน้าแดชบอร์ดสินค้า
│   ├── login.css              # ไฟล์สไตล์สำหรับหน้าล็อกอิน
│   └── register.css           # ไฟล์สไตล์สำหรับหน้าสมัครสมาชิก
├── images/
│   └── store/                 # โฟลเดอร์สำหรับเก็บไฟล์รูปภาพสินค้า
├── add.php                    # ฟอร์มและสคริปต์เพิ่มสินค้าใหม่
├── connect.php                # สคริปต์สำหรับเชื่อมต่อฐานข้อมูล MySQL
├── dashboard.php              # หน้าหลักแดชบอร์ดแสดงสินค้าและเมนูแก้ไข/ลบ
├── delete.php                 # สคริปต์สำหรับลบสินค้าและรูปภาพสินค้า
├── detail.php                 # หน้าแสดงรายละเอียดของสินค้าแต่ละรายการ
├── edit.php                   # ฟอร์มและสคริปต์สำหรับแก้ไขข้อมูลสินค้า
├── forgot_password.php        # หน้าตั้งค่ารหัสผ่านใหม่เมื่อลืมรหัสผ่าน
├── index.php                  # หน้าแรกสำหรับเข้าสู่ระบบ (Login)
├── logout.php                 # สคริปต์สำหรับออกจากระบบ
├── navbar.php                 # แถบเมนูด้านบน (Navigation Bar) แบบ Responsive
├── profile.php                # หน้าอัปเดตข้อมูลอีเมลและรูปโปรไฟล์ผู้ใช้งาน
└── register.php               # หน้าสมัครสมาชิกใหม่ (Register)
```
---
## 🛠️ ความต้องการของระบบ (Requirements)
* **Web Server:** Apache (เช่น XAMPP, Laragon, WampServer หรือ MAMP)
* **PHP Version:** 7.4 หรือมากกว่า
* **Database:** MySQL / MariaDB
* **Web Browser:** Modern Web Browser (Chrome, Firefox, Safari, Edge)
---
## 🚀 ขั้นตอนการติดตั้งและใช้งาน (Installation Guide)
### 1. โคลนหรือดาวน์โหลดโปรเจกต์
นำโฟลเดอร์โปรเจกต์ `basicweb` ไปวางไว้ในโฟลเดอร์รูทของเว็บเซิร์ฟเวอร์ของคุณ:
* **XAMPP:** `C:/xampp/htdocs/basicweb`
* **Laragon:** `C:/laragon/www/basicweb`
### 2. นำเข้าฐานข้อมูล (Database Setup)
1. เปิดบราวเซอร์และไปที่ **phpMyAdmin** (`http://localhost/phpmyadmin/`)
2. สร้างฐานข้อมูลใหม่ชื่อว่า **`basicweb`**
3. ไปที่แท็บ **SQL** แล้วคัดลอกคำสั่งด้านล่างนี้ไปรัน เพื่อสร้างตารางข้อมูล:
```sql
CREATE DATABASE IF NOT EXISTS `basicweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `basicweb`;
-- 1. สร้างตารางผู้ใช้งาน (users)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `profile_image` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- 2. สร้างตารางสินค้า (products)
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```
### 3. ตั้งค่าการเชื่อมต่อฐานข้อมูล
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "basicweb";
```
### 4. เริ่มใช้งานระบบ
1. ตรวจสอบให้มั่นใจว่ารันบริการ Apache และ MySQL ในโปรแกรมจำลองเซิร์ฟเวอร์แล้ว
2. เปิดเว็บบราวเซอร์แล้วเข้าไปที่ URL:
   `http://localhost/basicweb/index.php` (หรือตามพาธโฮสต์ของคุณ)
3. ทำการสมัครสมาชิกในหน้า `register.php` จากนั้นล็อกอินเข้าใช้งานระบบเพื่อจัดการสินค้าได้ทันที
---
## 🔒 ความปลอดภัยของระบบ (Security Measures)
* **Prepared Statements:** ปกป้องระบบจากการโจมตีประเภท SQL Injection ด้วยการใช้งาน `$conn->prepare()` และการ Bind parameters ทุกจุดที่มีการรับส่งข้อมูลระหว่างเซิร์ฟเวอร์กับฐานข้อมูล
* **Password Hashing:** รหัสผ่านของผู้ใช้งานทั้งหมดถูกเข้ารหัสอย่างปลอดภัยผ่านฟังก์ชัน `password_hash()` ด้วยอัลกอริทึม Bcrypt หรือ Default hashing ก่อนบันทึกลงฐานข้อมูล
* **Session Protection:** ระบบในส่วนหลังบ้านมีการตรวจสอบสิทธิ์ผ่าน Session ทำให้ไม่สามารถแอบเปิดผ่าน URL ตรงๆ ได้โดยไม่ผ่านการล็อกอิน
