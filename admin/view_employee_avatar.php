<?php
$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu'); 

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


$nhanvien = 1; 


$query = "SELECT avatar FROM nhanvien WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $nhanvien);
$stmt->execute();
$stmt->bind_result($avatar);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($avatar) {
    echo "<h2>Ảnh đại diện của Nhân viên:</h2>";
    echo "<img src='" . $avatar . "' alt='Avatar' width='150' height='150'>";
} else {
    echo "Nhân viên này chưa có ảnh đại diện.";
}
?>
