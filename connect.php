<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "cpe1234";
$dbname = "basicweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// แนะนำให้ใส่บรรทัดนี้เพิ่ม เพื่อให้ระบบรองรับภาษาไทยได้สมบูรณ์ครับ
$conn->set_charset("utf8mb4");
?>